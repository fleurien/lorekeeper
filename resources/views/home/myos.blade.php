@extends('home.layout')

@section('home-title')
    My MYO Slots
@endsection

@section('home-content')
    {!! breadcrumbs(['Characters' => 'characters', 'My MYO Slots' => 'myos']) !!}

    <h1>
        My MYO Slots
    </h1>

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
