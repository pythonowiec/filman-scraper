<?php

namespace Tests\Feature;

use App\Services\MediaApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class MediaApiServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Create a mock Guzzle Client
        $this->mockClient = Mockery::mock(Client::class);

        // Bind the mock client to the service container
        $this->app->instance(Client::class, $this->mockClient);

        // Instantiate the ApiService with the mocked client
        $this->apiService = new MediaApiService($this->mockClient);
    }

    public function testSearchMediaSuccess(): void
    {
        $response = [
            '0' => [
                'title' => 1,
                'poster' => 'http://example.com/image.jpg',
                'url' => 'https://example.com/test',
            ]
        ];

        $mockResponse = new Response(200, [], json_encode($response));

        $url = env('MEDIA_API_URL') . '/find_media';
        $title = 'Test';

        $this->mockClient
            ->shouldReceive('post')
            ->once()
            ->with($url, [
                'form_params' => [
                    'title' => $title
                ]
            ])
            ->andReturn($mockResponse);

        $result = $this->apiService->searchMedia($title);

        $this->assertEquals($response, $result);
    }


    public function testGetSeriesEpisodesSuccess(): void
    {
        $response = [
            '0' => [
                'title' => 1,
                'poster' => 'http://example.com/image.jpg',
                'url' => 'https://example.com/test',
            ]
        ];

        $mockResponse = new Response(200, [], json_encode($response));

        $url = env('MEDIA_API_URL') . '/find_series';

        $this->mockClient
            ->shouldReceive('post')
            ->once()
            ->with($url, [
                'form_params' => [
                    'url' => 'https:://example.com'
                ]
            ])
            ->andReturn($mockResponse);

        $result = $this->apiService->getSeriesEpisodes('https:://example.com');

        $this->assertEquals($response, $result);
    }

    #[DataProvider('statusesDataProvider')]
    public function testSearchMediaFailure(int $code, string $message): void
    {
        $url = env('MEDIA_API_URL') . '/find_media';

        $mockResponse = new Response($code);
        $request = new Request('POST', $url);
        $exception = new RequestException($message, $request, $mockResponse);

        $title = 'Test';

        $this->mockClient
            ->shouldReceive('post')
            ->once()
            ->with($url, [
                'form_params' => [
                    'title' => $title
                ]
            ])
            ->andThrow($exception);

        $result = $this->apiService->searchMedia($title);

        $this->assertEquals($message, $result);
    }

    #[DataProvider('statusesDataProvider')]
    public function testGetSeriesEpisodesFailure(int $code, string $message): void
    {
        $url = env('MEDIA_API_URL') . '/find_series';

        $mockResponse = new Response($code);
        $request = new Request('POST', $url);
        $exception = new RequestException($message, $request, $mockResponse);

        $this->mockClient
            ->shouldReceive('post')
            ->once()
            ->with($url, [
                'form_params' => [
                    'url' => 'https:://example.com'
                ]
            ])
            ->andThrow($exception);

        $result = $this->apiService->getSeriesEpisodes('https:://example.com');

        $this->assertEquals($message, $result);
    }

    public function testGetSeriesEpisodesOnMoviePage(): void
    {
        $url = env('MEDIA_API_URL') . '/find_series';

        $response = [];

        $mockResponse = new Response(200, [], json_encode($response));

        $this->mockClient
            ->shouldReceive('post')
            ->once()
            ->with($url, [
                'form_params' => [
                    'url' => 'https:://example.com'
                ]
            ])
            ->andReturn($mockResponse);

        $result = $this->apiService->getSeriesEpisodes('https:://example.com');

        $this->assertEquals([], $result);
    }

    public static function statusesDataProvider(): array
    {
        return [
            'when 404 not found' => ['code' => 404, 'message' => 'Not found any videos.'],
            'when 401 unauthorized' => ['code' => 401, 'message' => 'Not authorized.'],
            'when 500 error occurred' => ['code' => 500, 'message' => 'Something went wrong.'],
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
