@extends('worldexpansion.layout')

@section('title') Concept :: {{ $concept->name }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Concept' => 'world/concepts', $concept->name => 'world/concepts/'.$concept->id]) !!}
<h1 ><img src="{{$concept->thumbUrl}}" style="max-height:25px;vertical-align:inherit;"/>{!! $concept->displayName !!}@isset($concept->scientific_name)<span class="ml-2" style="opacity:0.5; font-size:0.7em;font-style:italic">{!! $concept->scientific_name !!}</span>@endisset</h1>
<h5>{!! $concept->category ? ucfirst($concept->category->displayName) : 'Miscellaneous' !!}</h5>

@if($concept->image_extension)
    <div class="text-center"><img src="{{$concept->imageUrl}}" class="mw-100 mb-3"/></div>
@endif

@isset($concept->summary)
<div class="world-entry-text px-3 text-center">{!! $concept->summary !!}</div>
@endisset

@isset($concept->parsed_description)
<div class="world-entry-text px-3">
    {!! $concept->parsed_description !!}
</div>
@endisset



<div class="row mx-0 px-0 mt-3">
    @if(count($concept->locations))
    <div class="text-center col-md mb-3"><div class="card h-100 py-3">
        <h5 class="mb-0">Location{{ count($concept->locations) == 1 ? '' : 's' }} Found In</h5>
        <!-- <hr>
        <p class="mb-0">
            @foreach($concept->locations as $key => $location)
                @if($location->thumb_extension)
                    <a href="{{ $location->url }}" data-toggle="tooltip" title="{{ $location->name }}"/><img src="{{$location->thumbUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else
                    {!! $location->displayName !!}
                @endif
            @endforeach
        </p> -->

        <hr>
        @foreach($concept->locations->groupBy('type_id') as $key => $locations)
        <p class="mb-0">
            <strong>
                @if($location_types->find($key))
                    {!! count($location_types->find($key)->locations) == 1 ? $location_types->find($key)->name : $location_types->find($key)->names !!}:
                @endif
            </strong>
            @foreach($locations as $key => $location) <strong>{!! $location->displayName !!}</strong><span>@if($key != count($locations)-1 && count($locations)>2),@endif</span>{{ $key == count($locations)-2 ? ' and ' : '' }}@endforeach
        </p>
        @endforeach
    </div></div>
    @endif

    @if(count($concept->items))
    <div class="text-center col-md mb-3"><div class="card h-100 py-3">
        <h5 class="mb-0">Associated Item{{ count($concept->items) == 1 ? '' : 's' }}:</h5>
        <!-- <hr>
        <p class="mb-0">
            @foreach($concept->items as $key => $item)
                @if($item->has_image)
                    <a href="{{ $item->url }}" data-toggle="tooltip" title="{{ $item->name }}"/><img src="{{$item->imageUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else
                    {!! $item->displayName !!}
                @endif
            @endforeach
        </p> -->

        <hr>

        @foreach($concept->items->groupBy('item_category_id') as $key => $items)
        <p class="mb-0">
            <strong>
                {{ $item_categories->find($key) ? $item_categories->find($key)->name : 'Miscellanous' }}:
            </strong>
            @foreach($items as $key => $item) <strong>{!! $item->displayName !!}</strong>@if($key != count($items)-1 && count($items)>2),@endif @if($key == count($items)-2) and @endif @endforeach
        </p>
        @endforeach

    </div></div>
    @endif
</div>


@endsection
