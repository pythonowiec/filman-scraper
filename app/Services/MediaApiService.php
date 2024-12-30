<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\Storage;

class MediaApiService
{

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function downloadMedia(): \Illuminate\Http\JsonResponse
    {
        $client = new Client();
        $url = 'http://192.168.8.100:5001/download_media';

        try {
            $response = $client->post($url, [
                'form_params' => [
                    'url' => 'https://filman.cc/serial-online/m-jak-milosc/222657/odcinek-1836/1375975', // Replace with your URL
                    'type' => 'PL',
                ]
            ]);

            $fileContent = $response->getBody()->getContents();

            Storage::disk('public')->put('downloaded_media/mediafile.mp4', $fileContent);

            return response()->json(['message' => 'File downloaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchMedia(string $title): array|string
    {
        $url = env('MEDIA_API_URL') . '/find_media';

        $result = '';

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'title' => $title
                ]
            ]);

            $result = $response->getBody()->getContents();
        } catch (GuzzleException $exception) {
            if ($exception->getCode() == 404) {
                return 'Not found any videos.';
            }

            if ($exception->getCode() == 500) {
                return 'Something went wrong.';
            }
        }

        return json_decode($result, true);
    }
}
