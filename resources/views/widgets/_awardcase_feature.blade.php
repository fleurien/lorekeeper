@if($target->awards->where('is_featured',1)->where('pivot.count','>',0)->count() && $count)
    <div class="{{ $float ? 'float-md-right ml-md-4' : '' }}" style="display: inline-block;max-width: 200px;position: relative;"><div class="row justify-content-center align-items-center">
        @foreach($target->awards->where('is_featured',1)->where('pivot.count','>',0)->unique()->take($count) as $award)
            <div class="text-center mb-1 px-1">
                <a href="{{$award->idUrl}}"><img src="{{ $award->imageUrl }}" alt="{{ $award->name }}"  style="max-width:100px;" data-toggle="tooltip" data-title="{{ $award->name }}"/></a>
            </div>
        @endforeach
    </div></div>
@endif