@extends('worldexpansion.layout')

@section('title') Factions @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Factions' => 'world/factions']) !!}
<h1>Factions</h1>

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

{!! $factions->render() !!}
<div class="row mx-0">
    @foreach($factions as $faction)
        <div class="col-12 col-md-4 mb-3"><div class="card mb-3 p-3 h-100">
            <div class="world-entry-image">
            @isset($faction->thumb_extension)
                <a href="{{ $faction->thumbUrl }}" data-lightbox="entry" data-title="{{ $faction->name }}"><img src="{{ $faction->thumbUrl }}" class="world-entry-image mb-3 mw-100" /></a>
            @endisset
            </div>
            <h3 class="mb-0 text-center">{!! $faction->fullDisplayName !!}</h3>
            <p class="mb-0 text-center">{!! $faction->category ? $faction->category->displayName : '' !!}</p>

            <p class="text-center mb-0"><strong>
                {!! $faction->type ? ucfirst($faction->type->displayName) : '' !!} {!! $faction->parent ? 'inside '.$faction->parent->displayName : '' !!}
            </strong></p>

            @if(($user_enabled && $faction->is_user_faction) || ($ch_enabled && $faction->is_character_faction))
                <p class="text-center mb-0"><strong>
                Can be joined by
                {!! $faction->is_character_faction && $faction->is_user_faction ? 'both' : '' !!}
                {!! $user_enabled && $faction->is_user_faction ? 'users' : '' !!}{!! $faction->is_character_faction && $faction->is_user_faction ? ' and' : '' !!}{!! !$faction->is_character_faction && $faction->is_user_faction ? '.' : '' !!}
                {!! $ch_enabled && $faction->is_character_faction ? 'characters.' : '' !!}
                </strong></p>
            @endif


            @if(count($faction->children))
                <strong class="mt-3 mb-0">Contains the following:</strong>
                @foreach($faction->children->groupBy('type_id') as $group => $children)
                <p class="mb-0">
                    <strong>
                        @if(count($children) == 1) {{ $loctypes->find($group)->name }}@else{{ $loctypes->find($group)->names }}@endif:
                    </strong>

                    @foreach($children as $key => $child) {!! $child->fullDisplayName !!}@if($key != count($children)-1), @endif @endforeach
                @endforeach
                </p>
            @endif

            @isset($faction->summary)
            <hr>
                <p class="mb-0"> {!! $faction->summary !!}</p>
            @endisset

        </div></div>
    @endforeach
</div>
{!! $factions->render() !!}

<div class="text-center mt-4 small text-muted">{{ $factions->total() }} result{{ $factions->total() == 1 ? '' : 's' }} found.</div>

@endsection
