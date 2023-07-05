@extends('admin.layout')

@section('admin-title') Emotes @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Emotes' => 'admin/emotes']) !!}

<h1>Emotes</h1>

<p>This is a list of emotes players/admins can use in the tinymce editor (and in comments).</p>

<div class="text-right mb-3">
    <a class="btn btn-primary" href="{{ url('admin/emotes/create') }}"><i class="fas fa-plus"></i> Create New Emote</a>
</div>

@if(!count($emotes))
    <p>No emotes found.</p>
@else
<table class="table table-sm emote-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Is Visible</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($emotes as $emote)
                <tr>
                    <td>
                    {!! $emote->imageUrl ? '<img src="'. $emote->imageUrl .'" class="img-fluid mr-2" style="height: 2em;" />' : ''!!} {{ $emote->name }}</a>
                    </td>
                    <td>{{$emote->is_active ? 'Active' : ' '}}</td>
                    <td class="text-right">
                        <a href="{{ url('admin/emotes/edit/'.$emote->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endif

@endsection

@section('scripts')
@parent
@endsection