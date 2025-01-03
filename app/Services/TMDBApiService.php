<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TMDBApiService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getMovieDetails(string $title): array|string
    {
        try {
            $response = $this->client->request('GET', sprintf('https://api.themoviedb.org/3/search/movie?query=%s&include_adult=false&language=pl-PL&page=1', rawurlencode($title)), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', env('TMDB_API_TOKEN')),
                    'accept' => 'application/json',
                ],
            ]);

            $results = json_decode($response->getBody()->getContents(), true)['results'];
            if (empty($results)) {
                return [];
            }

            return $results[0];

        } catch (GuzzleException $e) {
            switch ($e->getCode()) {
                case 404:
                    return 'Not found any videos.';
                case 401:
                    return 'Not authorized.';
                case 403:
                    return 'Forbidden.';
                default:
                    return 'Something went wrong.';
            }
        }
    }

    public function getSeriesDetails(string $title)
    {
        try {
            $response = $this->client->request('GET', sprintf('https://api.themoviedb.org/3/search/tv?query=%s&include_adult=false&language=pl-PL&page=1', rawurlencode($title)), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', env('TMDB_API_TOKEN')),
                    'accept' => 'application/json',
                ],
            ]);

            $results = json_decode($response->getBody()->getContents(), true)['results'];
            if (empty($results)) {
                return [];
            }

            return $results[0];

        } catch (GuzzleException $e) {
            switch ($e->getCode()) {
                case 404:
                    return 'Not found any videos.';
                case 401:
                    return 'Not authorized.';
                case 403:
                    return 'Forbidden.';
                default:
                    return 'Something went wrong.';
            }
        }
    }
}
