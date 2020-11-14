@extends('admin.layout')

@section('admin-title') Products @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Productss' => 'admin/data/productss', ($products->id ? 'Edit' : 'Create').' Products' => $products->id ? 'admin/data/productss/edit/'.$products->id : 'admin/data/productss/create']) !!}

<h1>{{ $products->id ? 'Edit' : 'Create' }} Products
    @if($products->id)
        <a href="#" class="btn btn-outline-danger float-right delete-products-button">Delete Products</a>
    @endif
</h1>

{!! Form::open(['url' => $products->id ? 'admin/data/productss/edit/'.$products->id : 'admin/data/productss/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="form-group">
    {!! Form::label('Item') !!}
    {!! Form::select('item_id', $items, null, ['class' => 'form-control stock-field', 'data-name' => 'item_id']) !!}
</div>

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {    
    $('.delete-products-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/data/productss/delete') }}/{{ $products->id }}", 'Delete Products');
    });
});
    
</script>
@endsection