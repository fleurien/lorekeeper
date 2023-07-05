@extends('admin.layout')

@section('admin-title') Emotes @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Emotes' => 'admin/emotes', ($emote->id ? 'Edit' : 'Create').' Emote' => $emote->id ? 'admin/emotes/edit/'.$emote->id : 'admin/emotes/create']) !!}

<h1>{{ $emote->id ? 'Edit' : 'Create' }} Emote
    @if($emote->id)
        <a href="#" class="btn btn-outline-danger float-right delete-emote-button">Delete Emote</a>
    @endif
</h1>

{!! Form::open(['url' => $emote->id ? 'admin/emotes/edit/'.$emote->id : 'admin/emotes/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="form-group">
    {!! Form::label('Name') !!}  {!! add_help('NOTE: Names with spaces don\'t play well with the emote generator, so try to use underscores if you have to') !!}
    {!! Form::text('name', $emote->name, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Image (Required)') !!}
    <div>{!! Form::file('image') !!}</div>
    @if($emote->has_image)
        <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
            {!! Form::label('remove_image', 'Remove current image', ['class' => 'form-check-label']) !!}
        </div>
    @endif
</div>

<div class="form-group">
    {!! Form::checkbox('is_active', 1, $emote->id ? $emote->is_active : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_active', 'Set Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, this emote will not be able to be used') !!}
</div>

<div class="text-right">
    {!! Form::submit($emote->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

@if($emote->id && $emote->imageUrl)
<h3>Preview</h3>
<div class="col-12 col-md-4 mb-3"><div class="card h-100">
            <div class="card-header">
            @if(Auth::check() && Auth::user()->hasPower('edit_data'))
                <a data-toggle="tooltip" title="[ADMIN] Edit emote" href="{{ url('admin/emotes/edit/').'/'.$emote->id }}" class="mb-2 float-right"><i class="fas fa-crown"></i></a>
            @endif
                <div class="world-entry-image">
                @isset($emote->imageUrl)
                    <img src="{{ $emote->imageUrl }}" class="world-entry-image mb-3 mw-100" />
                @endisset
                </div>
                <h3 class="mb-0 text-center">{!! $emote->name !!}</h3>
                <div class="card-header">
                <h5>Use This Emote</h5>
            </div>
            <div class="card-body">
            In the rich text editor:
                    <div class="alert alert-secondary">
                        [emote={{ $emote->id }}]
                    </div>
                    or:
                    <div class="alert alert-secondary">
                        [emote={{ $emote->name }}]
                    </div>
                    In comments and forums:
                    <div class="alert alert-secondary">
                    ![{{ $emote->name }}]({{ asset( $emote->imageUrl) }})
                    </div>
                </div>
            </div>


        </div></div>
@endif

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {
    $('.selectize').selectize();
    $('.delete-emote-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/emotes/delete') }}/{{ $emote->id }}", 'Delete Emote');
    });
});
</script>
@endsection