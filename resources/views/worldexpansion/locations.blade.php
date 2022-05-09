@extends('worldexpansion.layout')

@section('title') Locations @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Locations' => 'world/locations']) !!}
<h1>Locations</h1>

<div>
    {!! Form::open(['method' => 'GET', 'class' => '']) !!}
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
            <div class="form-group ml-3 mb-3">
                {!! Form::select('type_id', $types, Request::get('name'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::select('sort', [
                    'alpha'          => 'Sort Alphabetically (A-Z)',
                    'alpha-reverse'  => 'Sort Alphabetically (Z-A)',
                    'type'          => 'Sort by Type',
                    'newest'         => 'Newest First',
                    'oldest'         => 'Oldest First'    
                ], Request::get('sort') ? : 'type', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group ml-3 mb-3">
                {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>

{!! $locations->render() !!}
<div class="row mx-0">
    @foreach($locations as $location)
        <div class="col-12 col-md-4 mb-3"><div class="card mb-3 p-3 h-100">
            <div class="world-entry-image">
            @isset($location->thumb_extension) 
                <a href="{{ $location->thumbUrl }}" data-lightbox="entry" data-title="{{ $location->name }}"><img src="{{ $location->thumbUrl }}" class="world-entry-image mb-3 mw-100" /></a>
            @endisset
            </div>
            <h3 class="mb-0 text-center">{!! $location->fullDisplayName !!}</h3>
            <p class="mb-0 text-center">{!! $location->category ? $location->category->displayName : '' !!}</p>

            <p class="text-center mb-0"><strong>
                {!! $location->type ? ucfirst($location->type->displayName) : '' !!} {!! $location->parent ? 'inside '.$location->parent->displayName : '' !!}
            </strong></p>
                
            @if(($user_enabled && $location->is_user_home) || ($ch_enabled && $location->is_character_home))
                <p class="text-center mb-0"><strong>
                Can be home to 
                {!! $location->is_character_home && $location->is_user_home ? 'both' : '' !!}
                {!! $user_enabled && $location->is_user_home ? 'users' : '' !!}{!! $location->is_character_home && $location->is_user_home ? ' and' : '' !!}{!! !$location->is_character_home && $location->is_user_home ? '.' : '' !!}
                {!! $ch_enabled && $location->is_character_home ? 'characters.' : '' !!}
                </strong></p>   
            @endif


            @if(count($location->children))
                <strong class="mt-3 mb-0">Contains the following:</strong>
                @foreach($location->children->groupBy('type_id') as $group => $children)
                <p class="mb-0">
                    <strong>
                        @if(count($children) == 1) {{ $loctypes->find($group)->name }}@else{{ $loctypes->find($group)->names }}@endif:
                    </strong> 

                    @foreach($children as $key => $child) {!! $child->fullDisplayName !!}@if($key != count($children)-1), @endif @endforeach
                @endforeach
                </p>
            @endif

            @isset($location->summary)
            <hr>
                <p class="mb-0"> {!! $location->summary !!}</p>
            @endisset

        </div></div>
    @endforeach
</div>
{!! $locations->render() !!}

<div class="text-center mt-4 small text-muted">{{ $locations->total() }} result{{ $locations->total() == 1 ? '' : 's' }} found.</div>

@endsection
