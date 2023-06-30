<<<<<<< HEAD
{!! Form::label(ucfirst(__('transformations.transformation')).'(Optional)') !!}
{!! Form::select('transformation_id', $transformations, $image->transformation_id, ['class' => 'form-control', 'id' => 'transformation']) !!}
=======
{!! Form::label('Transformation (Optional)') !!}
{!! Form::select('transformation_id', $transformations, $image->transformation_id, ['class' => 'form-control', 'id' => 'transformation']) !!}
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
