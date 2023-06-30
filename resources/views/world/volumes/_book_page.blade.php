@extends('world.layout')

@section('title') {{ $book->name }} @endsection

@section('meta-img') {{ $book->imageUrl ? $book->imageUrl : null }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', __('volumes.library') => 'world/'.__('volumes.library'), $book->name => $book->idUrl]) !!}

<div class="card mb-3">
    <div class="card-body">
    @if(Auth::check() && Auth::user()->hasPower('edit_data'))
                <a data-toggle="tooltip" title="[ADMIN] Edit {{ __('volumes.book') }}" href="{{ url('admin/data/volumes/books/edit/').'/'.$book->id }}" class="mb-2 float-right"><i class="fas fa-crown"></i></a>
            @endif
        <div class="row world-entry">
            @if($imageUrl)
                <div class="col-md-3 world-entry-image"><a href="{{ $book->imageUrl }}" data-lightbox="entry" data-title="{{ $book->name }}"><img src="{{ $book->imageUrl }}" class="world-entry-image" alt="{{ $book->name }}"/></a></div>
            @endif
            <div class="{{ $book->imageUrl ? 'col-md-9' : 'col-12' }}">
            <h3>{!! $book->name !!}</h3>
            <div class="world-entry-text">
                {!! $book->parsed_description !!}
            </div>
            </div>
        </div>
    </div>
</div>

@if($book->volumes->count())
    <h2 class="text-center">{{ __('volumes.volumes') }}</h2>
    <div class="row">
            @foreach($book->volumes as $volume)
                @include('world.volumes._volume_entry', ['volume' => $volume, 'isAdmin' => false])
            @endforeach
</div> 
@endif

@endsection