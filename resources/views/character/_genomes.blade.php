@php
    $button = "";
    if (Auth::user() && Auth::user()->hasPower('manage_characters') && Auth::user()->hasPower('view_hidden_genetics')) {
        $button .= "<a href=\"#\" class=\"btn btn-link btn-sm ";
        if($genome)
            $button .= "edit-genome\" data-genome-id=\"". $genome->id ."\"><i class=\"fas fa-cog\"";
        else
            $button .= "add-genome\"><i class=\"fas fa-plus\"";

        $button .= "></i></a>";
        if($genome) $button .= "<a href=\"#\" class=\"btn btn-link btn-sm text-danger delete-genome\" data-genome-id=\"". $genome->id ."\"><i class=\"fas fa-minus\"></i></a>";
    }
@endphp

@if ($character->genomes->count())
    @foreach ($character->genomes as $genome)
        @include('character._genes', ['genome' => $genome])
    @endforeach
@else
    <div>This character's genes are hidden!</div>
@endif
