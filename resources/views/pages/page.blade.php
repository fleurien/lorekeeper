@extends('layouts.app')

@section('title')
    {{ $page->title }}
@endsection

@section('content')
<<<<<<< HEAD
{!! breadcrumbs([$page->title => $page->url]) !!}
<h1>{{ $page->title }}</h1>

<div class="mb-4">
    <div><strong>Created:</strong> {!! format_date($page->created_at) !!}</div>
    <div><strong>Last updated:</strong> {!! format_date($page->updated_at) !!}</div>
</div>  
=======
    <x-admin-edit title="Page" :object="$page" />
    {!! breadcrumbs([$page->title => $page->url]) !!}
    <h1>{{ $page->title }}</h1>
    <div class="mb-4">
        <div><strong>Created:</strong> {!! format_date($page->created_at) !!}</div>
        <div><strong>Last updated:</strong> {!! format_date($page->updated_at) !!}</div>
    </div>
>>>>>>> 7338c1a73a47b7c9d106c5d5ec9f96a7d72e9c56

    <div class="site-page-content parsed-text">
        {!! $page->parsed_text !!}
    </div>

    @if ($page->can_comment)
        <div class="container">
            @comments([
                'model' => $page,
                'perPage' => 5,
                'allow_dislikes' => $page->allow_dislikes,
            ])
        </div>
    @endif
@endsection
