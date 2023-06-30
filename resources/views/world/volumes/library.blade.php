@extends('world.layout')

@section('title') {{ ucfirst(__('volumes.library')) }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', ucfirst(__('volumes.library')) => 'world/'.__('volumes.library')]) !!}
<h1>{{ucfirst(__('volumes.library'))}}</h1>
<p>Here at the  {{__('volumes.library')}}, you can see all available  {{__('volumes.books')}} as well as the  {{__('volumes.volumes')}} contained within them.</p>
<div>
    {!! Form::open(['method' => 'GET', 'class' => '']) !!}
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
        </div>
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::select('sort', [
                    'alpha'          => 'Sort Alphabetically (A-Z)',
                    'alpha-reverse'  => 'Sort Alphabetically (Z-A)',
                    'newest'         => 'Newest First',
                    'oldest'         => 'Oldest First',
                ], Request::get('sort') ? : 'category', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group ml-3 mb-3">
                {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>

{!! $books->render() !!}
<div class="row">
    @foreach($books as $book)
    @include('world.volumes._book_entry', ['item' => null,'imageUrl' => $book->imageUrl, 'name' => $book->displayName, 'description' => $book->description, 'book'=>$book, 'searchUrl' => $book->searchUrl, 'isAdmin' => false])
    @endforeach
</div>
{!! $books->render() !!}

<div class="text-center mt-4 small text-muted">{{ $books->total() }} result{{ $books->total() == 1 ? '' : 's' }} found.</div>

@endsection
