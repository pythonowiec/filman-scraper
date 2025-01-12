<div>
    <div class="grid grid-cols-3">
        <div>
            <img src="{{sprintf('https://media.themoviedb.org/t/p/w300_and_h450_bestv2%s', $details['poster_path'])}}"
                 alt="{{$details['name'] ?? $details['title']}}"/>
        </div>
        <div class="col-span-2">
            <span class="text-xl">{{$details['name'] ?? $details['title']}} {{$details['vote_average']}}/10 ({{$details['vote_count']}})</span>
            <p>{{$details['overview']}}</p>
            <div class="flex flex-row mt-5 gap-2">
                <button>Add to watchlist</button>
                <button>Watch trailer</button>

            </div>
        </div>
    </div>

    <div class="flex flex-row mt-5 gap-2" x-data="{marked: ''}">
        <button class="video-type-btn" wire:click="setVideoType('Dubbing')" x-on:click="marked = 'Dubbing'"
                x-bind:class="marked == 'Dubbing' ? 'btn-marked' : ''">Dubbing {{session('message')}}
        </button>
        <button class="video-type-btn" wire:click="setVideoType('PL')" x-on:click="marked = 'PL'"
                x-bind:class="marked == 'PL' ? 'btn-marked' : ''">PL
        </button>
        <button class="video-type-btn" wire:click="setVideoType('Napisy')" x-on:click="marked = 'Napisy'"
                x-bind:class="marked == 'Napisy' ? 'btn-marked' : ''">Subtitles
        </button>
        <button class="video-type-btn" wire:click="setVideoType('Lektor')" x-on:click="marked = 'Lektor'"
                x-bind:class="marked == 'Lektor' ? 'btn-marked' : ''">Lector
        </button>
    </div>

    @if($messages)
        <div class="fixed right-5 top-0">
            @foreach($messages as $message)
                <div class="bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded relative mt-5 w-80"
                     role="alert" x-data="{open: true}" x-init="setTimeout(() => open = false, 3000)" x-show="open">
                    <span class="block sm:inline">{{$message}}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-gray-500" role="button" xmlns="http://www.w3.org/2000/svg"
                         x-on:click="open = ! open"
                         viewBox="0 0 20 20"><title>Close</title><path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-5">
        @if(is_array($episodesList) && !empty($episodesList))
            <span class="text-xl font-weight-bold">Episodes</span>
            @foreach($episodesList as $k => $detail)
                <li>
                    <a data-link="">{{$detail['title']}}</a>
                    <button
                        wire:click="downloadVideo('{{$details['name'] ?? $details['title']}} {{Str::match('/\[(.*?)\]/', $detail['title'])}}', '{{$detail['url']}}')">
                        <svg fill="#000000" height="24px" width="24px" id="Capa_1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 0 29.978 29.978" xml:space="preserve">
                                    <g>
                                        <path d="M25.462,19.105v6.848H4.515v-6.848H0.489v8.861c0,1.111,0.9,2.012,2.016,2.012h24.967c1.115,0,2.016-0.9,2.016-2.012
                                            v-8.861H25.462z"/>
                                        <path d="M14.62,18.426l-5.764-6.965c0,0-0.877-0.828,0.074-0.828s3.248,0,3.248,0s0-0.557,0-1.416c0-2.449,0-6.906,0-8.723
                                            c0,0-0.129-0.494,0.615-0.494c0.75,0,4.035,0,4.572,0c0.536,0,0.524,0.416,0.524,0.416c0,1.762,0,6.373,0,8.742
                                            c0,0.768,0,1.266,0,1.266s1.842,0,2.998,0c1.154,0,0.285,0.867,0.285,0.867s-4.904,6.51-5.588,7.193
                                            C15.092,18.979,14.62,18.426,14.62,18.426z"/>
                                    </g>
                                </svg>
                    </button>
                </li>
            @endforeach
        @endif

    </div>
</div>
