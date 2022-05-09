@extends('worldexpansion.layout')

@section('title') Fauna :: {{ $fauna->name }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Fauna' => 'world/faunas', $fauna->name => 'world/faunas/'.$fauna->id]) !!}
<h1 ><img src="{{$fauna->thumbUrl}}" style="max-height:25px;vertical-align:inherit;"/>{!! $fauna->displayName !!}@isset($fauna->scientific_name)<span class="ml-2" style="opacity:0.5; font-size:0.7em;font-style:italic">{!! $fauna->scientific_name !!}</span>@endisset</h1>
<h5>{!! $fauna->category ? ucfirst($fauna->category->displayName) : 'Miscellaneous' !!}</h5>

@if($fauna->image_extension)
    <div class="text-center"><img src="{{$fauna->imageUrl}}" class="mw-100 mb-3"/></div>
@endif

@isset($fauna->summary)
<div class="world-entry-text px-3 text-center">{!! $fauna->summary !!}</div>
@endisset

@isset($fauna->parsed_description)
<div class="world-entry-text px-3">
    {!! $fauna->parsed_description !!}
</div>
@endisset

    

<div class="row mx-0 px-0 mt-3">
    @if(count($fauna->locations))
    <div class="text-center col-md mb-3"><div class="card h-100 py-3">
        <h5 class="mb-0">Location{{ count($fauna->locations) == 1 ? '' : 's' }} Found In</h5>
        <!-- <hr>
        <p class="mb-0">
            @foreach($fauna->locations as $key => $location)
                @if($location->thumb_extension) 
                    <a href="{{ $location->url }}" data-toggle="tooltip" title="{{ $location->name }}"/><img src="{{$location->thumbUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else  
                    {!! $location->displayName !!}
                @endif
            @endforeach
        </p> -->
        
        <hr>
        @foreach($fauna->locations->groupBy('type_id') as $key => $locations)
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

    @if(count($fauna->items))
    <div class="text-center col-md mb-3"><div class="card h-100 py-3">
        <h5 class="mb-0">Associated Item{{ count($fauna->items) == 1 ? '' : 's' }}:</h5>
        <!-- <hr>
        <p class="mb-0">
            @foreach($fauna->items as $key => $item)
                @if($item->has_image) 
                    <a href="{{ $item->url }}" data-toggle="tooltip" title="{{ $item->name }}"/><img src="{{$item->imageUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else  
                    {!! $item->displayName !!}
                @endif
            @endforeach
        </p> -->
        
        <hr>

        @foreach($fauna->items->groupBy('item_category_id') as $key => $items)
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
