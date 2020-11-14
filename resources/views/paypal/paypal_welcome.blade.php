@extends('layouts.app')

@section('title') Cash Store @endsection

@section('content')
 <div class="container">

    @if (Session::has('message'))
     <div class="alert alert-{{ Session::get('code') }}">
      <p>{{ Session::get('message') }}</p>
     </div>
    @endif
 
<h3 class="text-center mb-4"> Stock </h3>
<hr>
@if(!count($products))
<p>No products found.</p>
@else 
<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 col-6 profile-inventory-item">
      {!! Form::open(['action' => 'PaypalController@expressCheckout']) !!}
        <div class="card p-3">
            <div class="text-center"><h3><strong>{!! $product->item->displayname !!}</a> @if($product->item->category !== Null )(<a href="{{ $product->item->category->url }}">{!! $product->item->category->name !!})@endif</strong></h3></div>
                    <div class="text-center inventory-character" data-id="{{ $product->id }}">
                        <div class="mb-1">
                            <img style="max-width: 150px;" src="{{ $product->item->imageurl }}">
                        </div>
                            <br>
                            <strong>Cost:</strong>
                            <br>
                            ${{ $product->price }}
                    @if($product->is_limited == 1)<div class="text-danger"> Limited Stock <br> Stock Remaining: {{ $product->quantity }}@endif
                    @if($product->use_user_bank == 1) <i class="fas fa-user" data-toggle="tooltip" title="Can be purchased using User Bank"></i> @endif
                    <br>
                    {{ Form::hidden('item', $product->item_id) }}
                    @if($product->is_limited)
                    {{ Form::hidden('stock', $product->quantity) }} 
                    @endif
                    {{ Form::hidden('total', $product->price) }}
                      {{Form::submit('Pay via Paypal', array('class' => 'btn-info btn text-white'))}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
@endsection