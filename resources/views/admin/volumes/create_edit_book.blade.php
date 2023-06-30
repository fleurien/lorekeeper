@extends('admin.layout')

@section('admin-title') {{ $book->id ? 'Edit' : 'Create' }} {{ ucfirst(__('volumes.book')) }} @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', ucfirst(__('volumes.books')) => 'admin/data/volumes/books', ($book->id ? 'Edit' : 'Create').' '.ucfirst(__('volumes.volume')) => $book->id ? 'admin/data/volumes/books/edit/'.$book->id : 'admin/data/volumes/books/create']) !!}

<h1>{{ $book->id ? 'Edit' : 'Create' }} {{ ucfirst(__('volumes.book')) }}
    @if($book->id)
        <a href="#" class="btn btn-danger float-right delete-book-button">Delete {{ucfirst(__('volumes.book'))}}</a>
    @endif
</h1>

{!! Form::open(['url' => $book->id ? 'admin/data/volumes/books/edit/'.$book->id : 'admin/data/volumes/books/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', $book->name, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::checkbox('is_visible', 1, $book->id ? $book->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the '.__('volumes.book').' will not be visible.') !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('World Page Image (Optional)') !!} {!! add_help('This image is used only on the world information pages.') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: 200px x 200px</div>
    @if($book->has_image)
        <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
            {!! Form::label('remove_image', 'Remove current image', ['class' => 'form-check-label']) !!}
        </div>
    @endif
</div>

<div class="form-group">
    {!! Form::label('Description (Optional)') !!}
    {!! Form::textarea('description', $book->description, ['class' => 'form-control wysiwyg']) !!}
</div>

<div class="form-group">
    {!! Form::label('Summary (Optional)') !!} {!! add_help('This is a short blurb that shows up on '.__('volumes.book').' index. HTML cannot be used here.') !!}
    {!! Form::text('summary', $book->summary, ['class' => 'form-control', 'maxLength' => 250]) !!}
</div>


<div class="text-right">
    {!! Form::submit($book->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

@if($book->id)
    <h3>Preview</h3>
            @include('world.volumes._book_entry', ['item' => null,'imageUrl' => $book->imageUrl, 'name' => $book->displayName, 'description' => $book->description, 'book'=>$book, 'searchUrl' => $book->searchUrl, 'isAdmin' => true])
@endif

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {    
    $('.delete-book-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/data/volumes/books/delete') }}/{{ $book->id }}", 'Delete {{ucfirst(__('volumes.book'))}}');
    });
});
    
</script>
@endsection