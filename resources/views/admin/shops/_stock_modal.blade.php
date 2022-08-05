<div class="p-2">
    @if($stock->id)
    {!! Form::open(['url' => 'admin/data/shops/stock/edit/'.$stock->id]) !!}
    @else
    {!! Form::open(['url' => 'admin/data/shops/stock/'.$shop->id]) !!}
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('stock_type', 'Type') !!}
                {!! Form::select('stock_type', ['Item' => 'Item'], $stock->stock_type ?? null, ['class' => 'form-control stock-field', 'placeholder' => 'Select Stock Type', 'id' => 'type']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" id="stock">
                @if($stock->stock_type == 'Item')
                    @include('admin.shops.stock._stock_item', ['items' => $items, 'stock' => $stock])
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('cost', 'Cost') !!}
        <div class="row">
            <div class="col-4">
                {!! Form::text('cost', $stock->cost ?? null, ['class' => 'form-control stock-field', 'data-name' => 'cost']) !!}
            </div>
            <div class="col-8">
                {!! Form::select('currency_id', $currencies, $stock->currency_id ?? null, ['class' => 'form-control stock-field', 'data-name' => 'currency_id']) !!}
            </div>
        </div>
    </div>
    
    <div class="pl-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::checkbox('use_user_bank', 1, $stock->use_user_bank ?? 1, ['class' => 'form-check-input stock-toggle stock-field', 'data-name' => 'use_user_bank']) !!}
                    {!! Form::label('use_user_bank', 'Use User Bank', ['class' => 'form-check-label ml-3']) !!} {!! add_help('This will allow users to purchase the item using the currency in their accounts, provided that users can own that currency.') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    {!! Form::checkbox('use_character_bank', 1, $stock->use_character_bank ?? 1, ['class' => 'form-check-input stock-toggle stock-field', 'data-name' => 'use_character_bank']) !!}
                    {!! Form::label('use_character_bank', 'Use Character Bank', ['class' => 'form-check-label ml-3']) !!} {!! add_help('This will allow users to purchase the item using the currency belonging to characters they own, provided that characters can own that currency.') !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::checkbox('is_fto', 1, $stock->is_fto ?? 0, ['class' => 'form-check-input stock-toggle stock-field', 'data-name' => 'is_fto']) !!}
            {!! Form::label('is_fto', 'FTO Only?', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned on, only FTO will be able to purchase the item.') !!}
        </div>

        <div class="form-group">
            {!! Form::checkbox('is_limited_stock', 1, $stock->is_limited_stock ?? 0, ['class' => 'form-check-input stock-limited stock-toggle stock-field', 'id' => 'is_limited_stock']) !!}
            {!! Form::label('is_limited_stock', 'Set Limited Stock', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned on, will limit the amount purchaseable to the quantity set below.') !!}
        </div>

        <div class="form-group">
            {!! Form::checkbox('is_visible', 1, $stock->is_visible ?? 1, ['class' => 'form-check-input stock-limited stock-toggle stock-field']) !!}
            {!! Form::label('is_visible', 'Set Visibility', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off it will not appear in the store.') !!}
        </div>
    </div>
    
    <div class="card mb-3 stock-limited-quantity hide">
        <div class="card-body">
            <div>
                {!! Form::label('quantity', 'Quantity') !!} {!! add_help('If left blank, will be set to 0 (sold out).') !!}
                {!! Form::text('quantity', $stock->quantity ?? 0, ['class' => 'form-control stock-field']) !!}
            </div>
        </div>
    </div>
    <div>
        {!! Form::label('purchase_limit', 'User Purchase Limit') !!} {!! add_help('This is the maximum amount of this item a user can purchase from this shop. Set to 0 to allow infinite purchases.') !!}
        {!! Form::text('purchase_limit', $stock->purchase_limit ?? 0, ['class' => 'form-control stock-field']) !!}
    </div>

<div class="text-right mt-1">
    {!! Form::submit('Add', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
</div>
<script>
    $(document).ready(function() {
        $('#type').change(function() {
            var type = $(this).val();
            $.ajax({
            type: "GET", url: "{{ url('admin/data/shops/stock-type') }}?type="+type, dataType: "text"
            }).done(function (res) { $("#stock").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
        });

        // is_limited_stock change
        $('#is_limited_stock').change(function() {
            if ($(this).is(':checked')) {
                $('.stock-limited-quantity').removeClass('hide');
            }
            else {
                $('.stock-limited-quantity').addClass('hide');
            }
        });
    });
</script>

