@if(Auth::check() && (Auth::user()->id == $character->user_id))
    <div class="text-center mb-4">
        <a href="#" class="btn btn-success create-breeding-permission">Create New gene pass</a>
    </div>
@endif

<p>
    This character has {{ $character->availableBreedingPermissions }} out of {{ $character->maxBreedingPermissions }} maximum gene passes{{ $character->availableBreedingPermissions == 1 ? '' : 's' }} available to create.
    @if(Auth::check() && (Auth::user()->id == $character->user_id))
        As the character's owner, you may create and grant to other users up to this many gene passes. Other users may see how many of this character's gene passes have been created and/or used, and to whom they have been granted.
    @else
        Only the character's owner can create and distribute their gene passes.
    @endif
</p>

@if($character->breedingPermissions->count())
    {!! $character->breedingPermissions->render() !!}

    @foreach($character->breedingPermissions as $permission)
        @include('character._breeding_permission', ['isCharacter' => true])
    @endforeach

    {!! $permissions->render() !!}
@else
    <p>No permissions found.</p>
@endif


@section('scripts')
    @parent
    @include('character._breeding_permissions_js')
@endsection



<div><h5>Genes</h5></div>
<div class="mb-3">
                    @include('character._genomes', ['character' => $character])
                </div>
<hr>
<div><h5>Genetic tree</h5></div>
@if($character->lineage !== null)
    <?php $line = $character->lineage; ?>
    @include('character._tab_lineage_tree', [
        'line' => [
            'sire' =>           $line->getDisplayName('sire'),
            'sire_sire' =>      $line->getDisplayName('sire_sire'),
            'sire_sire_sire' => $line->getDisplayName('sire_sire_sire'),
            'sire_sire_dam' =>  $line->getDisplayName('sire_sire_dam'),
            'sire_dam' =>       $line->getDisplayName('sire_dam'),
            'sire_dam_sire' =>  $line->getDisplayName('sire_dam_sire'),
            'sire_dam_dam' =>   $line->getDisplayName('sire_dam_dam'),
            'dam' =>            $line->getDisplayName('dam'),
            'dam_sire' =>       $line->getDisplayName('dam_sire'),
            'dam_sire_sire' =>  $line->getDisplayName('dam_sire_sire'),
            'dam_sire_dam' =>   $line->getDisplayName('dam_sire_dam'),
            'dam_dam' =>        $line->getDisplayName('dam_dam'),
            'dam_dam_sire' =>   $line->getDisplayName('dam_dam_sire'),
            'dam_dam_dam' =>    $line->getDisplayName('dam_dam_dam'),
        ]])
@else
    @include('character._tab_lineage_tree', [
        'line' => [
            'sire' => "Unknown",
            'sire_sire' => "Unknown",
            'sire_sire_sire' => "Unknown",
            'sire_sire_dam' => "Unknown",
            'sire_dam' => "Unknown",
            'sire_dam_sire' => "Unknown",
            'sire_dam_dam' => "Unknown",
            'dam' => "Unknown",
            'dam_sire' => "Unknown",
            'dam_sire_sire' => "Unknown",
            'dam_sire_dam' => "Unknown",
            'dam_dam' => "Unknown",
            'dam_dam_sire' => "Unknown",
            'dam_dam_dam' => "Unknown",
        ]])
@endif
@if(Auth::check() && Auth::user()->hasPower('manage_characters'))
    <div class="mt-3">
        <a href="#" class="btn btn-outline-info btn-sm edit-lineage" data-{{ $character->is_myo_slot ? 'id' : 'slug' }}="{{ $character->is_myo_slot ? $character->id : $character->slug }}"><i class="fas fa-cog"></i> Edit</a>
    </div>
@endif
<hr>
<div><h5>Genetic descendants</h5></div>
@php

use App\Models\Character\CharacterLineage;
        $children = CharacterLineage::getChildrenStatic($character->id, false);
@endphp
@if (!$children || $children->count() == 0)
        <p>No descendants found!</p>
    @else
        <div class="row">
            @foreach($children as $child)
                <div class="col-md-3 col-6 text-center mb-2">
                    <div>
                        <a href="{{ $child->url }}"><img src="{{ $child->image->thumbnailUrl }}" class="img-thumbnail" /></a>
                    </div>
                    <div class="mt-1 h5">
                        {!! $child->displayName !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
