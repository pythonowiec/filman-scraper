<?php

namespace App\Livewire;

use App\Services\MediaApiService;
use Illuminate\Support\Collection;
use Livewire\Component;

class Details extends Component
{
    public string|array $details;
    /**
     * @var \Illuminate\Foundation\Application|\Illuminate\Session\SessionManager|mixed|null
     */
    public string $url;
    public string $title    ;

    public function mount(MediaApiService $apiService): void
    {
        /** @var Collection $videos */
        $videos = session('searchResult');
        $this->title = $videos->get(session('clickedVideoKey'))['title'];
//        $this->details = $apiService->getSeriesEpisodes($this->url);
        $this->details = json_decode('{
    "0": {
        "title": "[s01e08] Odcinek 8",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/204043/odcinek-8/272002"
    },
    "1": {
        "title": "[s01e07] Odcinek 7",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/203564/odcinek-7/272002"
    },
    "2": {
        "title": "[s01e06] Odcinek 6",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/202988/odcinek-6/272002"
    },
    "3": {
        "title": "[s01e05] Odcinek 5",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/202267/odcinek-5/272002"
    },
    "4": {
        "title": "[s01e04] Odcinek 4",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/201660/odcinek-4/272002"
    },
    "5": {
        "title": "[s01e03] Odcinek 3",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/200991/odcinek-3/272002"
    },
    "6": {
        "title": "[s01e02] Odcinek 2",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/200278/odcinek-2/272002"
    },
    "7": {
        "title": "[s01e01] Odcinek 1",
        "url": "https://filman.cc/e/gwiezdne-wojny-akolita-star-wars-the-acolyte/200277/odcinek-1/272002"
    }
}', true);
    }

    public function render()
    {
        return view('livewire.details');
    }
}
