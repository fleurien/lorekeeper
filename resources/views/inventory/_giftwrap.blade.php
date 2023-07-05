<li class="list-group-item">
    <a class="card-title h5 collapse-title"  data-toggle="collapse" href="#wrapItem">Wrap Item</a>
    <div id="wrapItem" class="collapse">
        {!! Form::hidden('tag', $tag->tag) !!}
        <div id="wrapping-row">
            <div class="row">
                <div class="col-6">{!! Form::select('wrap_type', ['Item' => 'Item', /*'Character' => 'Character',*/ 'MYO' => 'MYO', 'Currency' => 'Currency'], null, ['class' => 'form-control wrap-type selectize', 'placeholder' => 'Select Item']) !!}</div>
                <div class="wrap-row-select col-6"></div>
            </div>
            @php $data = $tag->getEditData(); @endphp
            {!! Form::select('-', $data['items'], null, ['class' => 'form-control item-select hide', 'placeholder' => 'Select Item']) !!}
            {{-- {!! Form::select('-', $data['characters'], null, ['class' => 'form-control character-select hide', 'placeholder' => 'Select Character']) !!} --}}
            {!! Form::select('-', $data['myos'], null, ['class' => 'form-control myo-select hide', 'placeholder' => 'Select MYO']) !!}
            <div class="form-group d-flex currency-select hide">
                {!! Form::number('-', 0, ['class' => 'form-control mr-2', 'style' => 'width: 100px']) !!}
                {!! Form::select('-', $data['currencies'], null, ['class' => 'form-control', 'placeholder' => 'Select Currency']) !!}
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-check">
                        {!! Form::checkbox('display_contents', 0, false, ['class' => 'form-check-input', 'id' => 'display_contents']) !!}
                        {!! Form::label('display_contents', 'Display Contents in Wrapped Item\'s Notes', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>
            <div class="text-right">
                {!! Form::button('Wrap', ['class' => 'btn btn-primary', 'name' => 'action', 'value' => 'act', 'type' => 'submit']) !!}
            </div>
        </div>
    </div>
</li>

<script>
    var $items = $('#wrapping-row').find('.item-select');
    var $characters = $('#wrapping-row').find('.character-select');
    var $myos = $('#wrapping-row').find('.myo-select');
    var $currency = $('#wrapping-row').find('.currency-select');
    var $cell = $('#wrapping-row').find('.wrap-row-select');
    $(document).ready(function() {
        $('#wrapping-row .selectize').selectize();
    });
    $('#wrapping-row .wrap-type').on('change', function(e) {
        var val = $(this).val();

        var $clone = null;
        if(val == 'Item') $clone = $items.clone();
        else if (val == 'Character') $clone = $characters.clone();
        else if (val == 'MYO') $clone = $myos.clone();
        else if (val == 'Currency') {
            $clone = $currency.clone();
            $clone.find('input').attr('name', 'wrap_count');
            $clone.find('select').attr('name', 'wrap_id');
            $clone.find('select').selectize();
        }
        
        $clone.removeClass('hide');
        $clone.attr('name', 'wrap_id');

        $cell.html('');
        $cell.append($clone);
        if(val !== 'Currency')
            $clone.selectize();
    });
</script>