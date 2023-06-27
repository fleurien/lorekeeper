@extends('home.layout')

@section('home-title')
    My MYO Slots
@endsection

@section('home-content')
    {!! breadcrumbs(['Characters' => 'characters', 'My MYO Slots' => 'myos']) !!}

    <h1>
        My MYO Slots
    </h1>

<<<<<<< HEAD
<p>This is a list of MYO slots you own - click on a slot to view details about it. MYO slots can be submitted for design approval from their respective pages.</p>
<div id="sortable" class="row sortable">
    @foreach($slots as $slot)
        <div class="card m-2 highlight">
            <div class="card-img-top">
                <a href="{{ $slot->url }}"><img src="{{ $slot->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $slot->fullName }}" /></a>
            </div>
            <div class="card-title">
                {!! $slot->displayName !!}
            </div>
        </div>
    @endforeach
</div>
@endsection
=======
    <p>This is a list of MYO slots you own - click on a slot to view details about it. MYO slots can be submitted for design approval from their respective pages.</p>
    <div class="row">
        @foreach ($slots as $slot)
            <div class="col-md-3 col-6 text-center mb-2">
                <div>
                    <a href="{{ $slot->url }}"><img src="{{ $slot->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $slot->fullName }}" /></a>
                </div>
                <div class="mt-1 h5">
                    {!! $slot->displayName !!}
                </div>
            </div>
        @endforeach
    </div>
@endsection
>>>>>>> 7338c1a73a47b7c9d106c5d5ec9f96a7d72e9c56
