<?php

namespace App\Livewire;

use App\Events\DownloadEvent;
use App\Services\MediaApiService;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Livewire\Details;

class Library extends Component
{
    public string $title = '';
    public string|Collection $searchResult;
    public bool $loading = false;

    public function notify()
    {
        DownloadEvent::dispatch('Video was downloaded successfully.');

    }

    public function search(MediaApiService $apiService): void
    {
        $this->loading = true;
        $result = $apiService->searchMedia($this->title);
//        $result = json_decode('{
//  "0" : {
//    "title" : "Han Solo: Gwiezdne wojny - historie / Solo: A Star Wars Story",
//    "url" : "https://filman.cc/m/XtMY7z9D0PEFpKgyZQIanUNbe",
//    "poster" : "https://filman.cc/public/static/poster/big/8.jpg"
//  },
//  "1" : {
//    "title" : "Gwiezdne wojny VII: Przebudzenie Mocy / Star Wars: Episode VII - The Force Awakens",
//    "url" : "https://filman.cc/m/qQdmjYEBsW5V2fbl3HX4JMURv",
//    "poster" : "https://filman.cc/public/static/poster/big/273.jpg"
//  },
//  "2" : {
//    "title" : "Gwiezdne wojny: Część III - Zemsta Sithów / Star Wars: Episode III - Revenge of the Sith",
//    "url" : "https://filman.cc/m/Q1G8CDzOY7L2xiRZn3WNtAwmK",
//    "poster" : "https://filman.cc/public/static/poster/big/276.jpg"
//  },
//  "3" : {
//    "title" : "Gwiezdne wojny VIII: Ostatni Jedi / Star Wars: The Last Jedi",
//    "url" : "https://filman.cc/m/C6SUKsfbokYtI5LGmA2NiBrXn",
//    "poster" : "https://filman.cc/public/static/poster/big/779.jpg"
//  },
//  "4" : {
//    "title" : "Gwiezdne wojny: Część V - Imperium kontratakuje / Star Wars: Episode V - The Empire Strikes Back",
//    "url" : "https://filman.cc/m/yxdPsqpojH35rXTOaFuVzA9Jg",
//    "poster" : "https://filman.cc/public/static/poster/big/780.jpg"
//  },
//  "5" : {
//    "title" : "Gwiezdne wojny: Część II - Atak klonów / Star Wars: Episode II - Attack of the Clones",
//    "url" : "https://filman.cc/m/zseqbWDUaEhPVGo1n4wQiNgx3",
//    "poster" : "https://filman.cc/public/static/poster/big/781.jpg"
//  },
//  "6" : {
//    "title" : "Gwiezdne wojny: Część I - Mroczne widmo / Star Wars: Episode I - The Phantom Menace",
//    "url" : "https://filman.cc/m/9d8GZpmFKvgOx1SEc6zswYi20",
//    "poster" : "https://filman.cc/public/static/poster/big/782.jpg"
//  },
//  "7" : {
//    "title" : "Gwiezdne wojny: Część IV - Nowa nadzieja / Star Wars",
//    "url" : "https://filman.cc/m/oUpslXVCGj5dg8I7uv6wzSeAr",
//    "poster" : "https://filman.cc/public/static/poster/big/783.jpg"
//  },
//  "8" : {
//    "title" : "Łotr 1. Gwiezdne wojny - historie / Rogue One: A Star Wars Story",
//    "url" : "https://filman.cc/m/OszBiG1vdWECmNYq6aZIcUnJ5",
//    "poster" : "https://filman.cc/public/static/poster/big/784.jpg"
//  },
//  "9" : {
//    "title" : "Gwiezdne wojny: Część VI - Powrót Jedi / Star Wars: Episode VI - Return of the Jedi",
//    "url" : "https://filman.cc/m/gry9aV2GNR0sDW6CnfqIxM4EL",
//    "poster" : "https://filman.cc/public/static/poster/big/785.jpg"
//  },
//  "10" : {
//    "title" : "Prawda czy fałsz pogromcy mitów Gwiezdne wojny bez tajemnic / Mythbusters 10 Star Wars the Myths Strike Back",
//    "url" : "https://filman.cc/m/zF9SEN7DOZk2h6Hv1wPteQxiV",
//    "poster" : "https://filman.cc/public/static/poster/big/13363.jpg"
//  },
//  "11" : {
//    "title" : "Gwiezdne wojny: Wojny klonów / Star Wars: The Clone Wars",
//    "url" : "https://filman.cc/m/OgZPXqeUBuITStAkb2c8Q45Gx",
//    "poster" : "https://filman.cc/public/static/poster/big/40118.jpg"
//  },
//  "12" : {
//    "title" : "Gwiezdne wojny: Skywalker. Odrodzenie / Star Wars: The Rise of Skywalker",
//    "url" : "https://filman.cc/m/LZx0zGK32pwtQnj5TVgA1kbim",
//    "poster" : "https://filman.cc/public/static/poster/big/46235.jpg"
//  },
//  "13" : {
//    "title" : "LEGO Gwiezdne Wojny: Świąteczna przygoda / The Lego Star Wars Holiday Special",
//    "url" : "https://filman.cc/m/ZHToQldjEI4JFbs7cmKxSyk2g",
//    "poster" : "https://filman.cc/public/static/poster/big/51781.jpg"
//  },
//  "14" : {
//    "title" : "Gwiezdne wojny: Święta z rodziną Chewbacci / The Star Wars Holiday Special",
//    "url" : "https://filman.cc/m/OvbaR3F7fxB1dNw2CTYtU60Ji",
//    "poster" : "https://filman.cc/public/static/poster/big/51807.jpg"
//  },
//  "15" : {
//    "title" : "Gwiezdne wojny miliarderów / Space Titans",
//    "url" : "https://filman.cc/m/JhI9QZUgu31xt8YvFroXEplCK",
//    "poster" : "https://filman.cc/public/static/poster/big/54842.jpg"
//  },
//  "16" : {
//    "title" : "LEGO Gwiezdne wojny: Wakacje / LEGO Star Wars: Summer Vacation",
//    "url" : "https://filman.cc/m/n3EV9JfMrY07zXLmikcdFRwAj",
//    "poster" : "https://filman.cc/public/static/poster/big/56661.jpg"
//  },
//  "17" : {
//    "title" : "Gwiezdne wojny: Ruch oporu / Star Wars Resistance",
//    "url" : "https://filman.cc/s/861/gwiezdne-wojny-ruch-oporu-star-wars-resistance",
//    "poster" : "https://filman.cc/public/static/poster/big/861-series.jpg"
//  },
//  "18" : {
//    "title" : "Gwiezdne Wojny: Wojny Klonów / Star Wars: The Clone Wars",
//    "url" : "https://filman.cc/s/1531/gwiezdne-wojny-wojny-klonow-star-wars-the-clone-wars",
//    "poster" : "https://filman.cc/public/static/poster/big/1531-series.jpg"
//  },
//  "19" : {
//    "title" : "Gwiezdne Wojny: Parszywa zgraja / Star Wars: The Bad Batch",
//    "url" : "https://filman.cc/s/4169/gwiezdne-wojny-parszywa-zgraja-star-wars-the-bad-batch",
//    "poster" : "https://filman.cc/public/static/poster/big/4169-series.jpg"
//  },
//  "20" : {
//    "title" : "Gwiezdne wojny: Wizje / Star Wars: Visions",
//    "url" : "https://filman.cc/s/4506/gwiezdne-wojny-wizje-star-wars-visions",
//    "poster" : "https://filman.cc/public/static/poster/big/4506-series.jpg"
//  },
//  "21" : {
//    "title" : "Gwiezdne wojny: Galaktyka dźwięków / Star Wars: Galaxy of Sounds",
//    "url" : "https://filman.cc/s/5986/gwiezdne-wojny-galaktyka-dzwiekow-star-wars-galaxy-of-sounds",
//    "poster" : "https://filman.cc/public/static/poster/big/5986-series.jpg"
//  },
//  "22" : {
//    "title" : "Gwiezdne wojny: Opowieści Jedi / Star Wars: Tales of the Jedi",
//    "url" : "https://filman.cc/s/6349/gwiezdne-wojny-opowiesci-jedi-star-wars-tales-of-the-jedi",
//    "poster" : "https://filman.cc/public/static/poster/big/6349-series.jpg"
//  },
//  "23" : {
//    "title" : "Gwiezdne wojny: Przygody młodych Jedi / Star Wars: Young Jedi Adventures",
//    "url" : "https://filman.cc/s/7326/gwiezdne-wojny-przygody-mlodych-jedi-star-wars-young-jedi-adventures",
//    "poster" : "https://filman.cc/public/static/poster/big/7326-series.jpg"
//  },
//  "24" : {
//    "title" : "Gwiezdne Wojny: Opowieści z Imperium / Star Wars: Tales of the Empire",
//    "url" : "https://filman.cc/s/9402/gwiezdne-wojny-opowiesci-z-imperium-star-wars-tales-of-the-empire",
//    "poster" : "https://filman.cc/public/static/poster/big/9402-series.jpg"
//  },
//  "25" : {
//    "title" : "Gwiezdne wojny: Akolita / Star Wars: The Acolyte",
//    "url" : "https://filman.cc/s/9541/gwiezdne-wojny-akolita-star-wars-the-acolyte",
//    "poster" : "https://filman.cc/public/static/poster/big/9541-series.jpg"
//  },
//  "26" : {
//    "title" : "LEGO Gwiezdne Wojny: Odbuduj Galaktykę / LEGO Star Wars: Rebuild the Galaxy",
//    "url" : "https://filman.cc/s/10019/lego-gwiezdne-wojny-odbuduj-galaktyke-lego-star-wars-rebuild-the-galaxy",
//    "poster" : "https://filman.cc/public/static/poster/big/10019-series.jpg"
//  },
//  "27" : {
//    "title" : "Gwiezdne wojny: Załoga rozbitków / Star Wars: Skeleton Crew",
//    "url" : "https://filman.cc/s/10423/gwiezdne-wojny-zaloga-rozbitkow-star-wars-skeleton-crew",
//    "poster" : "https://filman.cc/public/static/poster/big/10423-series.jpg"
//  }
//}', true);
        $this->searchResult = collect($result);
        session(['searchResult' => $this->searchResult]);
        $this->loading = false;
    }

    public function showDetails(int $key, string $title): void
    {
        session([
            'clickedVideoKey' => $key,
        ]);

        $this->redirectRoute('details', ['title' => Str::slug($title)]);
    }

    public function render()
    {
        return view('livewire.library');
    }

}

