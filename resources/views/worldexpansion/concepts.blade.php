@extends('worldexpansion.layout')

@section('title') Concept @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Concepts' => 'world/concepts']) !!}
<h1>Concepts</h1>

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

{!! $concepts->render() !!}
<div class="row mx-0">
    @foreach($concepts as $concept)
        <div class="col-12 col-md-4 mb-3"><div class="card mb-3 p-3 h-100">
            <div class="world-entry-image">
            @isset($concept->thumb_extension)
                <a href="{{ $concept->thumbUrl }}" data-lightbox="entry" data-title="{{ $concept->name }}"><img src="{{ $concept->thumbUrl }}" class="world-entry-image mb-3 mw-100" /></a>
            @endisset
            </div>
            <h3 class="mb-0 text-center">{!! $concept->displayName !!}</h3>
            <p class="mb-0 text-center">{!! $concept->category ? $concept->category->displayName : '' !!}</p>

            @if(count($concept->locations))
                <p class="text-center mb-0">Found in {{ count($concept->locations) }} location{{ count($concept->locations) == 1 ? '' : 's' }}.</p>
            @endif
            @if(count($concept->items))
                <p class="text-center mb-0">Associated with {{ count($concept->items) }} item{{ count($concept->items) == 1 ? '' : 's' }}.</p>
            @endif

            @isset($concept->summary)
            <hr>
                <p class="mb-0"> {!! $concept->summary !!}</p>
            @endisset

        </div></div>
    @endforeach
</div>
{!! $concepts->render() !!}

<div class="text-center mt-4 small text-muted">{{ $concepts->total() }} result{{ $concepts->total() == 1 ? '' : 's' }} found.</div>

@endsection
