@extends('layouts.app')

@section('title') Cash Store @endsection

@section('content')
 <div class="container">

    @if (Session::has('message'))
     <div class="alert alert-{{ Session::get('code') }}">
      <p>{{ Session::get('message') }}</p>
     </div>
    @endif
 
  
    <div class="text-center">
        <h2>Item Stock</h2>
        <br>
        <div class="card-deck">
            <div class="card">
              @foreach($products as $product)
              {{ $product->price }}
              @endforeach
            </div>
          </div>
        </div>
@endsection