<ul>
    <li class="sidebar-header"><a href="{{ url('world') }}" class="card-link">Encyclopedia</a></li>
    @if(isset($sections) && $sections->count() > 0)
    <li class="sidebar-section">
        <div class="sidebar-section-header">Info</div>
        @foreach($sections as $section)
            <div class="sidebar-item"><a href="{{ url($section->url) }}" class="{{ set_active('world/info/'.$section->key) }}">{{ $section->name }}</a></div>
        @endforeach
    </li>
    @endif
    <li class="sidebar-section">
        <div class="sidebar-item"><a href="{{ url('world/info') }}">World Expanded</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Characters</div>
        <div class="sidebar-item"><a href="{{ url('world/species') }}" class="{{ set_active('world/species*') }}">Species</a></div>
        <div class="sidebar-item"><a href="{{ url('world/subtypes') }}" class="{{ set_active('world/subtypes*') }}">Subtypes</a></div>
        <div class="sidebar-item"><a href="{{ url('world/transformations') }}" class="{{ set_active('world/transformations*') }}">Transformations</a></div>
        <div class="sidebar-item"><a href="{{ url('world/rarities') }}" class="{{ set_active('world/rarities*') }}">Rarities</a></div>
        <div class="sidebar-item"><a href="{{ url('world/genetics') }}" class="{{ set_active('world/genetics*') }}">Genetics</a></div>
        <div class="sidebar-item"><a href="{{ url('world/trait-categories') }}" class="{{ set_active('world/trait-categories*') }}">Trait Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/traits') }}" class="{{ set_active('world/traits*') }}">All Traits</a></div>
        <div class="sidebar-item"><a href="{{ url('world/status-effects') }}" class="{{ set_active('world/status-effects*') }}">Status Effects</a></div>
        <div class="sidebar-item"><a href="{{ url('world/universaltraits') }}" class="{{ set_active('world/universaltraits*') }}">Universal Trait Index</a></div>
        <div class="sidebar-item"><a href="{{ url('world/character-categories') }}" class="{{ set_active('world/character-categories*') }}">Character Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/character-titles') }}" class="{{ set_active('world/character-titles*') }}">Character Titles</a></div>
        <div class="sidebar-item"><a href="{{ url('world/'.__('transformations.transformations')) }}" class="{{ set_active('world/'.__('transformations.transformations')) }}">{{ ucfirst(__('transformations.transformations')) }}</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Items</div>
        <div class="sidebar-item"><a href="{{ url('world/item-categories') }}" class="{{ set_active('world/item-categories*') }}">Item Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/items') }}" class="{{ set_active('world/items*') }}">All Items</a></div>
        <div class="sidebar-item"><a href="{{ url('world/currencies') }}" class="{{ set_active('world/currencies*') }}">Currencies</a></div>
        <div class="sidebar-item"><a href="{{ url('world/'.__('volumes.library')) }}" class="{{ set_active('world/'.__('volumes.library')) }}">{{ ucfirst(__('volumes.library')) }}</a></div>
        <div class="sidebar-item"><a href="{{ url('world/'.__('volumes.library').'/'.__('volumes.volumes')) }}" class="{{ set_active('world/'.__('volumes.library').'/'.__('volumes.volumes')) }}">All {{ ucfirst(__('volumes.volumes')) }}</a></div>
        <div class="sidebar-item"><a href="{{ url('world/collections') }}" class="{{ set_active('world/collections*') }}">Collections</a></div>
        <div class="sidebar-item"><a href="{{ url('world/collection-categories') }}" class="{{ set_active('world/collection-categories*') }}">Collection Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/emotes') }}" class="{{ set_active('world/emotes*') }}">Emotes</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">{{ ucfirst(__('awards.awards')) }}</div>
        <div class="sidebar-item"><a href="{{ url('world/'. __('awards.award') .'-categories') }}" class="{{ set_active('world/'. __('awards.award') .'-categories*') }}">{{ ucfirst(__('awards.award')) }} Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/'. __('awards.awards')) }}" class="{{ set_active('world/'. __('awards.awards') .'*') }}">All {{ ucfirst(__('awards.awards')) }} </a></div>
    </li>
</ul>
        <div class="sidebar-section-header">Levels</div>
        <div class="sidebar-item"><a href="{{ url('world/levels/user') }}" class="{{ set_active('world/levels/user*') }}">User Levels</a></div>
        <div class="sidebar-item"><a href="{{ url('world/levels/character') }}" class="{{ set_active('world/levels/character*') }}">Character Levels</a></div>
        <div class="sidebar-item"><a href="{{ url('world/stats') }}" class="{{ set_active('world/stats*') }}">Stats</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Claymore</div>
        <div class="sidebar-item"><a href="{{ url('world/weapon-categories') }}" class="{{ set_active('world/weapon-categories*') }}">Weapon Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/weapons') }}" class="{{ set_active('world/weapons*') }}">All Weapons</a></div>
        <div class="sidebar-item"><a href="{{ url('world/gear-categories') }}" class="{{ set_active('world/gear-categories*') }}">Gear Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/gear') }}" class="{{ set_active('world/gear*') }}">All Gear</a></div>
    </li>
<li>
        <div class="sidebar-section-header">Recipes</div>
        <div class="sidebar-item"><a href="{{ url('world/recipes') }}" class="{{ set_active('world/recipes*') }}">All Recipes</a></div>
    </li>
</ul>
