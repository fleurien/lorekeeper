@extends('home.layout')

@section('home-title')
    Oekaki
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('chickenpaint/chickenpaint.css') }}">
    <style>
        body {
			-webkit-user-select: none; /* For iOS Safari: Prevent long-press from popping up a selection dialog on body text */
            font-family: sans-serif;
        }
    </style>
@endpush

@push('head')
    <script src="{{ asset('chickenpaint/chickenpaint.js') }}"></script>
    <meta name="viewport" content="width=device-width,user-scalable=no">
@endpush

@section('home-content')
    {!! breadcrumbs(['Oekaki' => 'oekaki']) !!}

    <div id="chickenpaint-parent"></div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new ChickenPaint({
            uiElem: document.getElementById("chickenpaint-parent"),

            // If you have an image to load for editing (PNG or CHI), include these URLs:
            // loadImageUrl: "./image.png",
            // loadChibiFileUrl: "image.chi",

            // When you're hosting this on your own server you can add your own endpoints for drawing save here:
            // saveUrl: "save.php",
            // postUrl: "posting.php",
            // exitUrl: "forum.php",

            allowDownload: true,
            disableBootstrapAPI: true,
            fullScreenMode: "auto"
        });
    });
</script>
@endsection
