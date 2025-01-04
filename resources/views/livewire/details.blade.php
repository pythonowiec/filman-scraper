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

    <div class="mt-5">
        <span class="text-xl font-weight-bold">Episodes</span>
        @if(is_array($episodesList))
            @foreach($episodesList as $k => $detail)
                <li>
                    <a data-link="{{$detail['url']}}">{{$detail['title']}}</a>
                </li>
            @endforeach
        @endif

    </div>
</div>
