@extends('world.layout')

@section('title') {{ $volume->name }} @endsection

@section('meta-img') {{ $volume->imageUrl ? $volume->imageUrl : null }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', __('volumes.library') => 'world/'.__('volumes.library'),  Auth::check() && Auth::user()->hasVolume($volume->id) ? $volume->name : '???' => $volume->idUrl]) !!}

<div class="card mb-3">
    <div class="card-body">
    @if(Auth::check() && Auth::user()->hasPower('edit_data'))
                <a data-toggle="tooltip" title="[ADMIN] Edit {{ __('volumes.volume') }}" href="{{ url('admin/data/volumes/edit/').'/'.$volume->id }}" class="mb-2 float-right"><i class="fas fa-crown"></i></a>
            @endif
        <div class="row world-entry">
            @if(Auth::check() && Auth::user()->hasVolume($volume->id) || $volume->is_global == 1 && $volume->checkGlobal() > 0)
                @if($imageUrl)
                    <div class="col-md-3 world-entry-image"><a href="{{ $volume->imageUrl }}" data-lightbox="entry" data-title="{{ $volume->name }}"><img src="{{ $volume->imageUrl }}" class="world-entry-image" alt="{{ $volume->name }}"/></a></div>
                @endif
                <div class="{{ $volume->imageUrl ? 'col-md-9' : 'col-12' }}">
                <h3>{!! $volume->name !!}</h3>
                @if($volume->book)
                    <div>
                        <strong>In {{ __('volumes.book') }}: {!! $volume->book->displayName !!}</strong>
                    </div>
                    <br>
                @endif
                    <div class="world-entry-text">
                        {!! $volume->parsed_description !!}
                    </div>
                </div>
            @else 
                <div class="{{ $volume->imageUrl ? 'col-md-9' : 'col-12' }}">
                <h3>???</h3>
                    <div class="world-entry-text">
                        <i>??????</i>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
