<div class="row world-entry">
    <div class="{{ $species->speciesImageUrl ? 'col-md-12' : 'col-12' }}">
    
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
        
        <div class="world-entry-text">
            {!! $species->parsed_description !!}
        </div>
    </div>
</div>
