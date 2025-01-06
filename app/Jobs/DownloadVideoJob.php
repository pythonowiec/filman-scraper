<?php

namespace App\Jobs;

use App\Services\MediaApiService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DownloadVideoJob implements ShouldQueue
{
    use Queueable;

    private string $type;
    private string $videoUrl;
    private string $fileName;

    /**
     * Create a new job instance.
     */
    public function __construct(string $fileName, string $videoUrl, string $type)
    {
        $this->fileName = $fileName;
        $this->videoUrl = $videoUrl;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiService = new MediaApiService(new Client());
        $apiService->downloadMedia($this->fileName, $this->videoUrl, $this->type);
    }
}
