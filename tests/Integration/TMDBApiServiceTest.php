<?php

namespace Integration;

use App\Services\TMDBApiService;
use GuzzleHttp\Client;
use Tests\TestCase;

class TMDBApiServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client();
        $this->service = new TMDBApiService($this->client);

    }

    public function testGetMovieDetails(): void
    {
        $title = 'Gwiezdne wojny: Część III - Zemsta Sithów / Star Wars: Episode III - Revenge of the Sith';

        $response = $this->service
            ->getMovieDetails($title);

        $this->assertEquals([
            'adult' => false,
            'backdrop_path' => '/5vDuLrjJXFS9PTF7Q1xzobmYKR9.jpg',
            'genre_ids' => [
                12,
                28,
                878,
            ],
            'id' => 1895,
            'original_language' => 'en',
            'original_title' => 'Star Wars: Episode III - Revenge of the Sith',
            'overview' => "\"Gwiezdne wojny: Część III - Zemsta Sithów\" jest ostatnim rozdziałem słynnej sagi George'a Lucasa. Po trzech latach nieustannych walk nadchodzi koniec Wojny Klonów. Rada Jedi wysyła Obi-Wana Kenobiego, aby doprowadził przed wymiar sprawiedliwości Generała Grievousa, przywódcę armii Separatystów. Tymczasem w Republice Coruscant kanclerz Palpatine rośnie w siłę. Jego daleko idące polityczne zmiany przekształcają pogrążoną w wojnie Republikę w galaktyczne imperium. Kanclerz Palpatine czuje się na tyle silnym, że ogłasza się Imperatorem. Okazuje się, że ma on wielką moc. Wyznaje swojemu najbliższemu sprzymierzeńcowi, Anakinowi Skywalkerowi, prawdziwe źródło jej pochodzenia. Zwabiony potężną mocą Skywalker przechodzi na Ciemną Stronę i staje się złowrogim Darthem Vaderem.",
            'popularity' => 39.942,
            'poster_path' => '/llpo90dtzoq0b9MxYOyHx1mJc0s.jpg',
            'release_date' => '2005-05-17',
            'title' => 'Gwiezdne wojny: Część III - Zemsta Sithów',
            'video' => false,
            'vote_average' => 7.4,
            'vote_count' => 13761,
        ], $response);
    }

    public function testGetMovieNotFound(): void
    {
        $title = 'test test test 123';

        $response = $this->service
            ->getMovieDetails($title);

        $this->assertEquals([], $response);
    }

    public function testGetSeriesDetails(): void
    {
        $title = 'Gwiezdne Wojny: Wojny Klonów / Star Wars: The Clone Wars';

        $response = $this->service
            ->getSeriesDetails($title);

        $this->assertEquals([
            'adult' => false,
            'backdrop_path' => '/m6eRgkR1KC6Mr6gKx6gKCzSn6vD.jpg',
            'genre_ids' => [
                10759,
                16,
                10765
            ],
            'id' => 4194,
            'origin_country' => [
                'US'
            ],
            'original_language' => 'en',
            'original_name' => 'Star Wars: The Clone Wars',
            'overview' => 'Yoda, Obi-Wan Kenobi, Anakin Skywalker, Mistrz Windu i inni Rycerze Jedi przewodzą Wielkiej Armii Republiki przeciwko armii droidów Separatystów.',
            'popularity' => 205.284,
            'poster_path' => '/xDP12TfIuiN12eZe1wjP9ualjK.jpg',
            'first_air_date' => '2008-10-03',
            'name' => 'Gwiezdne wojny: Wojny klonów',
            'vote_average' => 8.5,
            'vote_count' => 2034,
        ], $response);
    }


    public function testGetSeriesNotFound(): void
    {
        $title = 'test test test 123';

        $response = $this->service
            ->getSeriesDetails($title);

        $this->assertEquals([], $response);
    }
}
