@extends('character.layout', ['isMyo' => true])

@section('profile-title')
    {{ $character->fullName }}
@endsection

@section('profile-content')
    {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url]) !!}

    @include('character._header', ['character' => $character])

    {{-- Main Image --}}
    <div class="row mb-3">
        <div class="text-center col-md-7">
            <a href="{{ $character->image->imageUrl }}" data-lightbox="entry" data-title="{{ $character->fullName }}">
                <img src="{{ $character->image->imageUrl }}" class="image" alt="{{ $character->fullName }}" />
            </a>
        </div>
        @include('character._image_info', ['image' => $character->image])
    </div>

@endsection

@section('scripts')
    @parent
    @include('character._image_js')
@endsection
