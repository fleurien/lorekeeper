@extends('world.layout')

@section('title') Emotes @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Emotes' => 'world/emotes']) !!}
<h1>Emotes</h1>

<div>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
        </div>
    {!! Form::close() !!}
</div>

<p>Emotes that you can use on world pages or the tinymce editor.</p>


{!! $emotes->render() !!}
<div class="row mx-0">
    @foreach($emotes as $emote)
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
    @endforeach
</div>
{!! $emotes->render() !!}

<div class="text-center mt-4 small text-muted">{{ count($emotes) }} result{{ count($emotes) == 1 ? '' : 's' }} found.</div>

@endsection