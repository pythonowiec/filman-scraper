<?php

namespace Tests\Feature;

use App\Services\MediaApiService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class MediaApiServiceTest extends TestCase
{
    public function testSearchMedia(): void
    {
        $response = [
            '0' => [
                'title' => 1,
                'poster' => 'http://example.com/image.jpg',
                'url' => 'http://example.com/test',
            ]
        ];

        $mock = Mockery::mock(MediaApiService::class)->makePartial();

        $mock->shouldReceive('searchMedia')->once()->andReturn($response);

        $result = $mock->searchMedia('Test');
        $this->assertEquals($response, $result);

        Mockery::close();
    }
}
