@extends('home.layout')

@section('home-title')
    My Characters
@endsection

@section('home-content')
    {!! breadcrumbs(['My Characters' => 'characters']) !!}

    <h1>
        My Characters
    </h1>

    <p>This is a list of characters you own. Drag and drop to rearrange them.</p>

<<<<<<< HEAD
<div id="sortable" class="row sortable">
    @foreach($characters as $character)
        <div class="card m-2 highlight" data-id="{{ $character->id }}">
            <div class="card-img-top">
                <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $character->fullName }}" /></a>
            </div>
            <div class="card-title">
                {!! $character->displayName !!}
            </div>
        </div>
    @endforeach
</div>
{!! Form::open(['url' => 'characters/sort', 'class' => 'text-right']) !!}
=======
    <div id="sortable" class="row sortable">
        @foreach ($characters as $character)
            <div class="col-md-3 col-6 text-center mb-2" data-id="{{ $character->id }}">
                <div>
                    <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $character->fullName }}" /></a>
                </div>
                <div class="mt-1 h5">
                    {!! $character->displayName !!}
                </div>
            </div>
        @endforeach
    </div>
    {!! Form::open(['url' => 'characters/sort', 'class' => 'text-right']) !!}
>>>>>>> 7338c1a73a47b7c9d106c5d5ec9f96a7d72e9c56
    {!! Form::hidden('sort', null, ['id' => 'sortableOrder']) !!}
    {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#sortable").sortable({
                characters: '.sort-item',
                placeholder: "sortable-placeholder col-md-3 col-6",
                stop: function(event, ui) {
                    $('#sortableOrder').val($(this).sortable("toArray", {
                        attribute: "data-id"
                    }));
                },
                create: function() {
                    $('#sortableOrder').val($(this).sortable("toArray", {
                        attribute: "data-id"
                    }));
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
@endsection
