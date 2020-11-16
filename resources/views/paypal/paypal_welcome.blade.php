@extends('layouts.app')

@section('title') Cash Store @endsection

@section('content')
 <div class="container">

    @if (Session::has('message'))
     <div class="alert alert-{{ Session::get('code') }}">
      {{ Session::get('message') }}
     </div>
    @endif
 
<h3 class="text-center mb-4"> Stock </h3>
<hr>
@if(!count($products->where('is_bundle', 0)))
<p class="text-center">No products found.</p>
@else 
<div class="row">
    @foreach($products->where('is_bundle', 0) as $product)
    <div class="col-md-3 col-6 profile-inventory-item">
      {!! Form::open(['action' => 'PaypalController@expressCheckout']) !!}
        <div class="card p-3">
            <div class="text-center"><h3><strong>{!! $product->item->displayname !!}</a> @if($product->item->category !== Null )(<a href="{{ $product->item->category->url }}">{!! $product->item->category->name !!})@endif</strong></h3></div>
                    <div class="text-center inventory-character">
                        <div class="mb-1">
                            <img style="max-width: 150px;" src="{{ $product->item->imageurl }}">
                        </div>
                            <br>
                            <strong>Cost:</strong>
                            <br>
                            ${{ $product->price }}
                        @if($product->is_limited)<div class="text-danger"> Limited Stock <br> Stock Remaining: {{ $product->quantity }} </div>@endif
                        <br>
                        {{ Form::hidden('item', $product->item_id) }}
                        @if($product->is_limited)
                        {{ Form::hidden('stock', $product->id) }} 
                        @endif
                        {{ Form::hidden('total', $product->price) }}
                        @if($product->is_limited)
                            @if($product->quantity > 0) 
                            {{ Form::number('amount', 1, [ 'class' => 'form-control mb-1', 'min' => 1,]) }}
                            {{ Form::submit('Pay via Paypal', array('class' => 'btn-info btn text-white')) }} 
                            @else Out of Stock @endif
                        @else
                        {{ Form::number('amount', 1, [ 'class' => 'form-control mb-1', 'min' => 1,]) }}
                        {{ Form::submit('Pay via Paypal', array('class' => 'btn-info btn text-white')) }}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    @endforeach
</div>
@endif
<br>
<h3 class="text-center mb-4"> Bundle Stock </h3>
    <hr>
        @if(!count($products->where('is_bundle', 1)))
        <p class="text-center">No products found.</p>
        @else 
            <div class="row">
                @foreach($products->where('is_bundle', 1) as $product)
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
                            @if($product->is_bundle == 1) <div class="text-success"> Bundle </div>@endif
                            @if($product->is_limited == 1)<div class="text-danger"> Limited Stock <br> Stock Remaining: {{ $product->quantity }} </div>@endif
                        <br>
                        {{ Form::hidden('item', $product->item_id) }}
                        @if($product->is_limited) 
                        {{ Form::hidden('stock', $product->id) }}
                        @endif
                        {{ Form::hidden('total', $product->price) }}
                        @if($product->is_limited)
                            @if($product->quantity > 0) 
                            {{ Form::number('amount', 1, [ 'class' => 'form-control mb-1', 'min' => 1,]) }}
                            {{ Form::submit('Pay via Paypal', array('class' => 'btn-info btn text-white')) }} 
                            @else Out of Stock @endif
                        @else
                        {{ Form::number('amount', 1, [ 'class' => 'form-control mb-1', 'min' => 1,]) }}
                        {{ Form::submit('Pay via Paypal', array('class' => 'btn-info btn text-white')) }}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    @endforeach
</div>
@endif
@endsection