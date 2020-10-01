@extends('layouts.app')

@section('title') 
    Shops :: 
    @yield('research-title')
@endsection

@section('sidebar')
    @include('research._sidebar')
@endsection

@section('content')
    @yield('research-content')
@endsection

@section('scripts')
@parent
@endsection