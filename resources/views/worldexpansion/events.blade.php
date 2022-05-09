@extends('worldexpansion.layout')

@section('title') Events @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Events' => 'world/events']) !!}
<h1>Events</h1>

<div>
    {!! Form::open(['method' => 'GET', 'class' => '']) !!}
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
            <div class="form-group ml-3 mb-3">
                {!! Form::select('type_id', $categories, Request::get('name'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::select('sort', [
                    'alpha'          => 'Sort Alphabetically (A-Z)',
                    'alpha-reverse'  => 'Sort Alphabetically (Z-A)',
                    'category'          => 'Sort by Category',
                    'newest'         => 'Newest First',
                    'oldest'         => 'Oldest First'
                ], Request::get('sort') ? : 'category', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group ml-3 mb-3">
                {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>

{!! $events->render() !!}
<div class="row mx-0">
    @foreach($events as $event)
        <div class="col-12 col-md-4 mb-3"><div class="card mb-3 p-3 h-100">
            <div class="world-entry-image">
            @isset($event->thumb_extension)
                <a href="{{ $event->thumbUrl }}" data-lightbox="entry" data-title="{{ $event->name }}"><img src="{{ $event->thumbUrl }}" class="world-entry-image mb-3 mw-100" /></a>
            @endisset
            </div>
            <h3 class="mb-0 text-center">{!! $event->displayName !!}</h3>
            <p class="mb-0 text-center">{!! $event->category ? $event->category->displayName : '' !!}</p>

            @if(count($event->locations))
                <p class="text-center mb-0">Associated with {{ count($event->locations) }} location{{ count($event->locations) == 1 ? '' : 's' }}.</p>
            @endif
            @if(count($event->factions))
                <p class="text-center mb-0">Associated with {{ count($event->factions) }} faction{{ count($event->factions) == 1 ? '' : 's' }}.</p>
            @endif
            @if(count($event->figures))
                <p class="text-center mb-0">Associated with {{ count($event->figures) }} figure{{ count($event->figures) == 1 ? '' : 's' }}.</p>
            @endif

            @isset($event->summary)
            <hr>
                <p class="mb-0"> {!! $event->summary !!}</p>
            @endisset

        </div></div>
    @endforeach
</div>
{!! $events->render() !!}

<div class="text-center mt-4 small text-muted">{{ $events->total() }} result{{ $events->total() == 1 ? '' : 's' }} found.</div>

@endsection
