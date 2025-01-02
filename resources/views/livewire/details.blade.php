<div>
    {{$title}}
    @if(is_array($details))
        @foreach($details as $k => $detail)
            <li>
                <a data-link="{{$detail['url']}}">{{$detail['title']}}</a>
            </li>
        @endforeach
    @endif
</div>
