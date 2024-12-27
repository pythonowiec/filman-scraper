<?php

namespace App\Services;
use GuzzleHttp\Client;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\Storage;

class MediaApiService
{

    public function downloadMedia(): \Illuminate\Http\JsonResponse
    {
        $client = new Client();
        $url = 'http://192.168.8.100:5001/download_media';

        try {
            $response = $client->post($url, [
                'form_params' => [
                    'url' => 'https://filman.cc/serial-online/m-jak-milosc/222657/odcinek-1836/1375975', // Replace with your URL
                    'type' => 'PL', // Replace with your type
                ]
            ]);

            // Get the file content from the response
            $fileContent = $response->getBody()->getContents();

            // Optionally save the file locally
            Storage::disk('public')->put('downloaded_media/mediafile.mp4', $fileContent);

            return response()->json(['message' => 'File downloaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchMedia(string $title): string
    {
        $client = new Client();

        $url = 'http://192.168.8.100:5002/find_media';

        $response = $client->post($url, [
            'form_params' => [
                'title' => $title
            ]
        ]);

        $result = $response->getBody()->getContents();

        return $this->sanitizeHtml($result);
    }

    private function sanitizeHtml($html): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($html);
    }

}
