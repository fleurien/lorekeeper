@extends('worldexpansion.layout')

@section('title') Fauna @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Fauna' => 'world/faunas']) !!}
<h1>Fauna</h1>

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

{!! $faunas->render() !!}
<div class="row mx-0">
    @foreach($faunas as $fauna)
        <div class="col-12 col-md-4 mb-3"><div class="card mb-3 p-3 h-100">
            <div class="world-entry-image">
            @isset($fauna->thumb_extension) 
                <a href="{{ $fauna->thumbUrl }}" data-lightbox="entry" data-title="{{ $fauna->name }}"><img src="{{ $fauna->thumbUrl }}" class="world-entry-image mb-3 mw-100" /></a>
            @endisset
            </div>
            <h3 class="mb-0 text-center">{!! $fauna->displayName !!}</h3>
            <p class="mb-0 text-center">{!! $fauna->category ? $fauna->category->displayName : '' !!}</p>
            
            @if(count($fauna->locations))
                <p class="text-center mb-0">Found in {{ count($fauna->locations) }} location{{ count($fauna->locations) == 1 ? '' : 's' }}.</p>
            @endif
            @if(count($fauna->items))
                <p class="text-center mb-0">Associated with {{ count($fauna->items) }} item{{ count($fauna->items) == 1 ? '' : 's' }}.</p>
            @endif

            @isset($fauna->summary)
            <hr>
                <p class="mb-0"> {!! $fauna->summary !!}</p>
            @endisset

        </div></div>
    @endforeach
</div>
{!! $faunas->render() !!}

<div class="text-center mt-4 small text-muted">{{ $faunas->total() }} result{{ $faunas->total() == 1 ? '' : 's' }} found.</div>

@endsection
