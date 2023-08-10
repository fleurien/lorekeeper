@if ($character->genomes->count())
<div><h5>Genes</h5></div>
    @foreach ($character->genomes as $genome)
        @include('character._genes', ['genome' => $genome])
    @endforeach
@else
    <div>No genes listed.</div>
@endif
