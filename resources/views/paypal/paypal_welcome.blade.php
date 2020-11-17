@extends('layouts.app')

@section('title') Cash Store @endsection

@section('content')
 <div class="container">

    @if (Session::has('message'))
     <div class="alert alert-{{ Session::get('code') }}">
      {{ Session::get('message') }}
     </div>
    @endif
 
<h3 class="text-center mb-4"> {{ $shop->title }} </h3>
    <div class="text-center">
        {!! $shop->desc !!}
    </div>
<hr>
@if(!count($products->where('is_bundle', 0)))
<p class="text-center">No products found.</p>
@else 
<div class="row">
    @foreach($products->where('is_bundle', 0) as $product)
    @if($product->is_limited && $product->quantity <= 0) <div class="col-md-3 col-6 profile-inventory-item" style="opacity: 50%">
    @else <div class="col-md-3 col-6 profile-inventory-item">
    @endif
      {!! Form::open(['action' => 'PaypalController@expressCheckout']) !!}
        <div class="card p-3" style="height: 385px">
            <div class="text-center"><h3><strong>{!! $product->item->displayname !!}</strong></h3></div>
            @if($product->item->category !== Null ) <div class="text-muted"><small>(<a href="{{ $product->item->category->url }}">{!! $product->item->category->name !!})</small></div>@endif
                    <div class="text-center inventory-character">
                        <div class="mb-1">
                            <img style="width: 50%;" src="{{ $product->item->imageurl }}">
                        </div>
                            <br>
                            <strong>Cost:</strong>
                            <br>
                            ${{ $product->price }}
                            <br>
                        @if($product->is_limited)<div class="text-danger"> Stock Remaining: {{ $product->quantity }}/0 </div>
                        @else <div class="text-success"> Stock: &infin;</div>
                        @endif
                        {{ Form::hidden('item', $product->item_id) }}
                        @if($product->is_limited)
                        {{ Form::hidden('stock', $product->id) }} 
                        @endif
                        {{ Form::hidden('total', $product->price) }}
                        @if($product->is_limited)
                            @if($product->quantity > 0) 
                            {{ Form::number('amount', 1, [ 'class' => 'form-control mb-1', 'min' => 1,]) }}
                            {{ Form::submit('Pay via Paypal', array('class' => 'btn-info btn-sm btn text-white')) }} 
                            @else <div class="text-danger"> Out of Stock </div>
                            {{ Form::number('amount', 1, ['disabled' => 'disabled', 'class' => 'form-control mb-1', 'min' => 1,]) }}
                            {{ Form::submit('Pay via Paypal', array('disabled' => 'disabled', 'class' => 'btn-info btn text-white')) }}
                            @endif
                        @else
                        {{ Form::number('amount', 1, [ 'class' => 'form-control mb-1', 'min' => 1,]) }}
                        {{ Form::submit('Pay via Paypal', array('class' => 'btn-info btn-sm btn text-white')) }}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    @endforeach
</div>
@endif
<br>
<h3 class="text-center mb-4"> {{ $shop->btitle }} </h3>
    <div class="text-center">
        {!! $shop->bdesc !!}
    </div>
<hr>
@if(!count($products->where('is_bundle', 1)))
<p class="text-center">No products found.</p>
@else 
    <div class="row">
        @foreach($products->where('is_bundle', 1) as $product)
        @if($product->is_limited && $product->quantity <= 0) <div class="col-md-3 col-6 profile-inventory-item" style="opacity: 50%">
            @else <div class="col-md-3 col-6 profile-inventory-item">
            @endif
                    {!! Form::open(['action' => 'PaypalController@expressCheckout']) !!}
        <div class="card p-3" style="height: 385px">
            <div class="text-center"><h3><strong>{!! $product->item->displayname !!}</a></strong></h3></div>
            @if($product->item->category !== Null ) <h6><div class="text-muted text-center"><a href="{{ $product->item->category->url }}">{!! $product->item->category->name !!}</div></h6></a>@endif
                <div class="text-center inventory-character" data-id="{{ $product->id }}">
                    <div class="mb-1">
                            <img style="width: 50%;" src="{{ $product->item->imageurl }}">
                        </div>
                        <br>
                            <strong>Cost:</strong>
                            <br>
                                ${{ $product->price }}
                            <br>
                            @if($product->is_bundle == 1) <div class="text-success"> Bundle </div>@endif
                            @if($product->is_limited == 1)<div class="text-danger"> Stock Remaining: {{ $product->quantity }} </div>
                            @else <div class="text-success"> Stock: &infin;</div>
                            @endif
                        {{ Form::hidden('item', $product->item_id) }}
                        @if($product->is_limited) 
                        {{ Form::hidden('stock', $product->id) }}
                        @endif
                        {{ Form::hidden('total', $product->price) }}
                        @if($product->is_limited)
                            @if($product->quantity > 0) 
                            {{ Form::number('amount', 1, [ 'class' => 'form-control mb-1', 'min' => 1,]) }}
                            {{ Form::submit('Pay via Paypal', array('class' => 'btn-info btn text-white')) }} 
                            @else Out of Stock 
                            {{ Form::number('amount', 1, ['disabled' => 'disabled', 'class' => 'form-control mb-1', 'min' => 1,]) }}
                            {{ Form::submit('Pay via Paypal', array('disabled' => 'disabled', 'class' => 'btn-info btn text-white')) }}
                            @endif
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