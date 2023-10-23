@extends('world.layout')

@section('title')
    Species
@endsection

@section('content')
    {!! breadcrumbs(['World' => 'world', 'Species' => 'world/species']) !!}
    <h1>Species</h1>

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    {!! $specieses->render() !!}
    @foreach ($specieses as $species)
        <div class="card mb-3">
            <div class="card-body">
                @include('world._species_entry', ['species' => $species])
            </div>
        </div>
    @endforeach
    {!! $specieses->render() !!}





    {!! $subtypes->render() !!}
    <div class="row text-center">
    @foreach ($species->subtypes as $subtype)
        <div class="col">
                @include('world._subtype_entry', ['subtype' => $subtype])
        </div>
    @endforeach
</div>
    {!! $subtypes->render() !!}

@endsection
