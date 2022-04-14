@extends('worldexpansion.layout')

@section('title') {{ $location->style }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Locations' => 'world/locations', $location->style => 'world/locations/'.$location->id]) !!}
<h1><img src="{{$location->thumbUrl}}" style="max-height:25px;vertical-align:inherit;"/>{!! $location->style !!}</h1>
<h5 class="mb-0">{!! ucfirst($location->type->displayName) !!} {!! $location->parent ? 'inside '.$location->parent->displayName : '' !!}</h5>

@if(($user_enabled && $location->is_user_home) || ($ch_enabled && $location->is_character_home))
    <p class="mb-0"><strong>
    Can be home to
    {!! $location->is_character_home && $location->is_user_home ? 'both' : '' !!}
    {!! $user_enabled && $location->is_user_home ? 'users' : '' !!}{!! $location->is_character_home && $location->is_user_home ? ' and' : '' !!}{!! !$location->is_character_home && $location->is_user_home ? '.' : '' !!}
    {!! $ch_enabled && $location->is_character_home ? 'characters.' : '' !!}
    </strong></p>
@endif


@if($location->image_extension)
    <div class="text-center"><img src="{{$location->imageUrl}}" class="mw-100"/></div>
@endif

@isset($location->summary)
<div class="world-entry-text px-3 text-center">{!! $location->summary !!}</div>
@endisset

@isset($location->parsed_description)
<div class="world-entry-text px-3">
    {!! $location->parsed_description !!}
</div>
@endisset

<div class="row mx-0 px-0 mt-3">
    @if(count($location->children))
    <div class="text-center col-md mb-3 fb-md-50"><div class="card h-100 py-3">
    <h5 class="mb-0">Contains the following</h5>

        <!-- <hr>
        <p class="mb-0">
            @foreach($location->children as $key => $child)
                @if($child->thumb_extension)
                    <a href="{{ $child->url }}" data-toggle="tooltip" title="{{ $child->name }}"/><img src="{{$child->thumbUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else
                    {!! $child->displayName !!}
                @endif
            @endforeach
        </p> -->

        <hr>
        @foreach($location->children->groupBy('type_id') as $group => $children)
        <p class="mb-0">
            <strong>
                @if(count($children) == 1) {{ $loctypes->find($group)->name }}@else{{ $loctypes->find($group)->names }}@endif:
            </strong>
            @foreach($children as $key => $child) {!! $child->fullDisplayName !!}@if($key != count($children)-1), @endif @endforeach
        </p>
        @endforeach
    </div></div>
    @endif

    @if(count($location->fauna))
    <div class="text-center col-md mb-3 fb-md-50"><div class="card h-100 py-3">
        <h5 class="mb-0">Fauna</h5>

        <!-- <hr>
        <p class="mb-0">
            @foreach($location->fauna as $key => $fauna)
                @if($fauna->thumb_extension)
                    <a href="{{ $fauna->url }}" data-toggle="tooltip" title="{{ $fauna->name }}"/><img src="{{$fauna->thumbUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else
                    {!! $fauna->displayName !!}
                @endif
            @endforeach
        </p> -->

        <hr>
        @foreach($location->fauna->groupBy('category_id') as $key => $faunas)
        <p class="mb-0">
            <strong>
                {{ $fauna_categories->find($key) ? $fauna_categories->find($key)->name : 'Miscellanous' }}:
            </strong>
            @foreach($faunas as $key => $fauna) <strong>{!! $fauna->displayName !!}</strong>@if($key != count($faunas)-1 && count($faunas)>2),@endif @if($key == count($faunas)-2) and @endif @endforeach
        </p>
        @endforeach
    </div></div>
    @endif

    @if(count($location->flora))
    <div class="text-center col-md mb-3 fb-md-50"><div class="card h-100 py-3">
        <h5 class="mb-0">Flora</h5>

        <!-- <hr>
        <p class="mb-0">
            @foreach($location->flora as $key => $flora)
                @if($flora->thumb_extension)
                    <a href="{{ $flora->url }}" data-toggle="tooltip" title="{{ $flora->name }}"/><img src="{{$flora->thumbUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else
                    {!! $flora->displayName !!}
                @endif
            @endforeach
        </p> -->

        <hr>
        @foreach($location->flora->groupBy('category_id') as $key => $floras)
        <p class="mb-0">
            <strong>
                {{ $flora_categories->find($key) ? $flora_categories->find($key)->name : 'Miscellanous' }}:
            </strong>
            @foreach($floras as $key => $flora) <strong>{!! $flora->displayName !!}</strong>@if($key != count($floras)-1 && count($floras)>2),@endif @if($key == count($floras)-2) and @endif @endforeach
        </p>
        @endforeach
    </div></div>
    @endif

    @if(count($location->events))
    <div class="text-center col-md mb-3 fb-md-50"><div class="card h-100 py-3">
        <h5 class="mb-0">Associated Event{{ count($location->events) == 1 ? '' : 's'}}</h5>

        <!-- <hr>
        <p class="mb-0">
            @foreach($location->events as $key => $event)
                @if($event->thumb_extension)
                    <a href="{{ $event->url }}" data-toggle="tooltip" title="{{ $event->name }}"/><img src="{{$event->thumbUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else
                    {!! $event->displayName !!}
                @endif
            @endforeach
        </p> -->

        <hr>
        @foreach($location->events->groupBy('category_id') as $key => $events)
        <p class="mb-0">
            <strong>
                {{ $event_categories->find($key) ? $event_categories->find($key)->name : 'Miscellanous' }}:
            </strong>
            @foreach($events as $key => $event) <strong>{!! $event->displayName !!}</strong>@if($key != count($events)-1 && count($events)>2),@endif @if($key == count($events)-2) and @endif @endforeach
        </p>
        @endforeach
    </div></div>
    @endif

    @if(count($location->factions))
    <div class="text-center col-md mb-3 fb-md-50"><div class="card h-100 py-3">
        <h5 class="mb-0">Associated Faction{{ count($location->factions) == 1 ? '' : 's'}}</h5>

        <!-- <hr>
        <p class="mb-0">
            @foreach($location->factions as $key => $faction)
                @if($faction->thumb_extension)
                    <a href="{{ $faction->url }}" data-toggle="tooltip" title="{{ $faction->name }}"/><img src="{{$faction->thumbUrl}}" class="m-1" style="max-width:100px"/> </a>
                @else
                    {!! $faction->displayName !!}
                @endif
            @endforeach
        </p> -->

        <hr>
        @foreach($location->factions->groupBy('type_id') as $key => $factions)
        <p class="mb-0">
            <strong>
                {{ $faction_categories->find($key) ? $faction_categories->find($key)->name : 'Miscellanous' }}:
            </strong>
            @foreach($factions as $key => $faction) <strong>{!! $faction->displayName !!}</strong>@if($key != count($factions)-1 && count($factions)>2),@endif @if($key == count($factions)-2) and @endif @endforeach
        </p>
        @endforeach
    </div></div>
    @endif


</div>

    @if(count($location->gallerysubmissions))
        <div class="text-center col-md mb-3 fb-md-50"><div class="card h-100 py-3">
            <h5 class="mb-0">Associated Gallery Submission{{ count($location->gallerysubmissions) == 1 ? '' : 's'}}</h5><hr>

        <div class="d-flex align-content-around flex-wrap mb-2">
            @foreach($location->gallerysubmissions->sortByDesc('created_at')->take(3) as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => true])
            @endforeach
        </div>
        @if(count($location->gallerysubmissions) > 2)
            <p class="text-right mr-4 mb-0"><a href="{{ url('world/locations/').'/'.$location->id.'/submissions'}}">See All {{count($location->gallerysubmissions)}}</p>
        @endif
    @endif


@endsection
