@if($emote)
    {!! Form::open(['url' => 'admin/emotes/delete/'.$emote->id]) !!}

    <p>Are you sure you want to delete <strong>{{ $emote->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete Emote', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else 
    Invalid emote selected.
@endif