@if ($character->genomes->count())
    @foreach ($character->genomes as $genome)
        @include('character._genes', ['genome' => $genome])
    @endforeach
@else
    <div>This character's genes are hidden!</div>
    @include('character._genes', ['genome' => $genome])
@endif

