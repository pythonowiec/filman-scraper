<?php

namespace Feature;

use App\Services\MediaApiService;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class MediaApiServiceTest extends TestCase
{
    public function testSearchMedia(): void
    {
        $response = '<div>Test Test <p>Test</p></div>';

        $mock = Mockery::mock(MediaApiService::class)->makePartial();

        // Define expected method calls and their return values
        $mock->shouldReceive('searchMedia')->once()->andReturn($response);

        // Use the mock in your test
        $result = $mock->searchMedia('Test');
        $this->assertEquals('<div>Test Test <p>Test</p></div>', $result);

        // Ensure the mock expectations are verified
        Mockery::close();
    }
}
