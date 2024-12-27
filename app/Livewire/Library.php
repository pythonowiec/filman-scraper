<?php

namespace App\Livewire;

use App\Services\MediaApiService;
use HTMLPurifier;
use HTMLPurifier_Config;
use Livewire\Component;

class Library extends Component
{
    public string $title = ''; // Binds to the search input
    public string $searchResult = ''; // Stores search results or messages
    public bool $loading = false;

    public function search(MediaApiService $apiService): void
    {
        $this->loading = true;
        $this->searchResult = $apiService->searchMedia($this->title);
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.library');
    }

}

