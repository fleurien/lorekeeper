<h3>Generated Gift-Wrapped</h3>
<p>The item with the tag of "Gift Wrapped" that will be generated once an item has been "wrapped".</p>
<div class="mb-3"> 
    {!! Form::select('wrap_id', $giftwrappeds, $tag->data, ['class' => 'form-control item-select selectize', 'placeholder' => 'Select Item']) !!}
</div>