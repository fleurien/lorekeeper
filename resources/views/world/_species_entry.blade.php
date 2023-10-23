<div class="row world-entry">
    @if ($species->speciesImageUrl)
        <div class="col-md-3 world-entry-image">
            <a href="{{ $species->speciesImageUrl }}" data-lightbox="entry" data-title="{{ $species->name }}">
                <img src="{{ $species->speciesImageUrl }}" class="world-entry-image" alt="{{ $species->name }}" />
            </a>
        </div>
    @endif
    <div class="{{ $species->speciesImageUrl ? 'col-md-9' : 'col-12' }}">
        <x-admin-edit title="Species" :object="$species" />
        <h3>
            @if (!$species->is_visible)
                <i class="fas fa-eye-slash mr-1"></i>
            @endif
            {!! $species->displayName !!}
            <a href="{{ $species->searchUrl }}" class="world-entry-search text-muted">
                <i class="fas fa-search"></i>
            </a>
        </h3>
        @if (count($species->features) && Config::get('lorekeeper.extensions.species_trait_index.enable'))
            <a href="{{ $species->visualTraitsUrl }}">
                <strong>Visual Trait Index</strong>
            </a>
        @endif
        
        <div class="world-entry-text">
            {!! $species->parsed_description !!}
        </div>
    </div>
</div>
