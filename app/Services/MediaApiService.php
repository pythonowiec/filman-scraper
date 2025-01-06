<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaApiService
{

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function downloadMedia(string $fileName, string $videoUrl, string $type): void
    {
        $url = env('MEDIA_API_URL') . '/download_media';

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'url' => $videoUrl,
                    'type' => $type,
                ]
            ]);

            $fileContent = $response->getBody()->getContents();

            Storage::disk('public')->put(sprintf('downloaded_media/%s.mp4', $fileName), $fileContent);

            session([
                'message' => 'File downloaded successfully.',
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function searchMedia(string $title): array|string
    {
        $url = env('MEDIA_API_URL') . '/find_media';

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'title' => $title
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $exception) {
            switch ($exception->getCode()) {
                case 404:
                    return 'Not found any videos.';
                case 401:
                    return 'Not authorized.';
                default:
                    return 'Something went wrong.';
            }
        }

    }

    public function getSeriesEpisodes(string $seriesUrl): array|string
    {
        $url = env('MEDIA_API_URL') . '/find_series';

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'url' => $seriesUrl
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $exception) {
            switch ($exception->getCode()) {
                case 404:
                    return 'Not found any videos.';
                case 401:
                    return 'Not authorized.';
                default:
                    return 'Something went wrong.';
            }
        }

    }
}
