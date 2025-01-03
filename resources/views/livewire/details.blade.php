<div>
    <p>{{$details['name'] ?? $details['title']}} {{$details['vote_average']}} ({{$details['vote_count']}})</p>
    @if(is_array($episodesList))
        @foreach($episodesList as $k => $detail)
            <li>
                <a data-link="{{$detail['url']}}">{{$detail['title']}}</a>
            </li>
        @endforeach
    @endif
</div>
