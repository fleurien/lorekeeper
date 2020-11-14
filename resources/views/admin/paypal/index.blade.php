@extends('admin.layout')

@section('admin-title') Products @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Products' => 'admin/data/products']) !!}

<h1>Products</h1>

<p>Items that can be bought in the cash-store.</p>
<div>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('product', Request::get('product'), ['class' => 'form-control', 'placeholder' => 'Product']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>

<a href="products/create" class="btn btn-primary text-right mb-3">Make New Product</a>

@if(!count($products))
    <p>No products found.</p>
@else 
    {!! $products->render() !!}
    <table class="table table-sm setting-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Stock</th>
                <th>Quantity</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr class="sort-product" data-id="{{ $product->id }}">
                    <td>{{ $product->item->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>@if($product->quantity) {{ $product->quantity }} @else Unlimited @endif</td>
                    <td>
                        <td class="text-right">
                            <a href="{{ url('admin/data/products/edit/'.$product->id) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $products->render() !!}
@endif
@endsection