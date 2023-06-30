<<<<<<< HEAD
{!! Form::label(ucfirst(__('transformations.transformation')).' (Optional)') !!} @if ($isMyo)
    {!! add_help('This will lock the slot into a particular '.__('transformations.transformation').'. Leave it blank if you would like to give the user a choice, or not select a '.__('transformations.transformation').'.') !!}
@endif
{!! Form::select('transformation_id', $transformations, old('transformation_id'), ['class' => 'form-control', 'id' => 'transformation']) !!}
=======
{!! Form::label('Transformation (Optional)') !!} @if ($isMyo)
    {!! add_help('This will lock the slot into a particular transformation. Leave it blank if you would like to give the user a choice, or not select a transformation.') !!}
@endif
{!! Form::select('transformation_id', $transformations, old('transformation_id'), ['class' => 'form-control', 'id' => 'transformation']) !!}
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
