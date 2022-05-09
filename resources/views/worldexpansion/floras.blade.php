@extends('worldexpansion.layout')

@section('title') Flora @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Flora' => 'world/floras']) !!}
<h1>Flora</h1>

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
                    'category'       => 'Sort by Category',
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

{!! $floras->render() !!}
<div class="row mx-0">
    @foreach($floras as $flora)
        <div class="col-12 col-md-4 mb-3"><div class="card mb-3 p-3 h-100">
            <div class="world-entry-image">
            @isset($flora->thumb_extension) 
                <a href="{{ $flora->thumbUrl }}" data-lightbox="entry" data-title="{{ $flora->name }}"><img src="{{ $flora->thumbUrl }}" class="world-entry-image mb-3 mw-100" /></a>
            @endisset
            </div>
            <h3 class="mb-0 text-center">{!! $flora->displayName !!}</h3>
            <p class="mb-0 text-center">{!! $flora->category ? $flora->category->displayName : '' !!}</p>
            
            @if(count($flora->locations))
                <p class="text-center mb-0">Found in {{ count($flora->locations) }} location{{ count($flora->locations) == 1 ? '' : 's' }}.</p>
            @endif
            @if(count($flora->items))
                <p class="text-center mb-0">Associated with {{ count($flora->items) }} item{{ count($flora->items) == 1 ? '' : 's' }}.</p>
            @endif

            @isset($flora->summary)
            <hr>
                <p class="mb-0"> {!! $flora->summary !!}</p>
            @endisset

        </div></div>
    @endforeach
</div>
{!! $floras->render() !!}

<div class="text-center mt-4 small text-muted">{{ $floras->total() }} result{{ $floras->total() == 1 ? '' : 's' }} found.</div>

@endsection
