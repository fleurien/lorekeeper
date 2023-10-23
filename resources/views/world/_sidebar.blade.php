<ul>
    <li class="sidebar-header"><a href="{{ url('world') }}" class="card-link">Gamedex</a></li>
    @if(isset($sections) && $sections->count() > 0)
    <li class="sidebar-section">
        <div class="sidebar-section-header">Info</div>
        @foreach($sections as $section)
            <div class="sidebar-item"><a href="{{ url($section->url) }}" class="{{ set_active('world/info/'.$section->key) }}">{{ $section->name }}</a></div>
        @endforeach
    </li>
    @endif
    <li class="sidebar-section">
        <div class="sidebar-section-header"><a href="{{ url('world/info') }}"><i class="fa-solid fa-globe fa-flip" style="--fa-animation-duration: 3s;"></i> World Lore</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Characters</div>
        <div class="sidebar-item"><a href="{{ url('world/species') }}" class="{{ set_active('world/species*') }}">Poffins</a></div>
        <div class="sidebar-item"><a href="{{ url('world/genetics') }}" class="{{ set_active('world/genetics*') }}">Genetics</a></div>
        <div class="sidebar-item"><a href="{{ url('world/universaltraits') }}" class="{{ set_active('world/universaltraits*') }}">Trait sheet</a></div>
        <div class="sidebar-item"><a href="{{ url('world/status-effects') }}" class="{{ set_active('world/status-effects*') }}">Status Effects</a></div>
        <div class="sidebar-item"><a href="{{ url('world/levels/character') }}" class="{{ set_active('world/levels/character*') }}">Level guide</a></div>
        <div class="sidebar-item"><a href="{{ url('world/skills') }}" class="{{ set_active('world/skills*') }}">Skills</a></div>
        <div class="sidebar-item"><a href="{{ url('world/character-titles') }}" class="{{ set_active('world/character-titles*') }}">Character Titles</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Items</div>
        <div class="sidebar-item"><a href="{{ url('world/item-categories') }}" class="{{ set_active('world/item-categories*') }}">Item Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/items') }}" class="{{ set_active('world/items*') }}">All Items</a></div>
        <div class="sidebar-item"><a href="{{ url('world/pet-categories') }}" class="{{ set_active('world/pet-categories*') }}">Pet Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/pets') }}" class="{{ set_active('world/pets*') }}">All Pets</a></div>
        <div class="sidebar-item"><a href="{{ url('world/weapon-categories') }}" class="{{ set_active('world/weapon-categories*') }}">Weapon Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/weapons') }}" class="{{ set_active('world/weapons*') }}">All Weapons</a></div>
        <div class="sidebar-item"><a href="{{ url('world/gear-categories') }}" class="{{ set_active('world/gear-categories*') }}">Gear Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/gear') }}" class="{{ set_active('world/gear*') }}">All Gear</a></div>
        <div class="sidebar-item"><a href="{{ url('world/collections') }}" class="{{ set_active('world/collections*') }}">Collections</a></div>
        <div class="sidebar-item"><a href="{{ url('world/recipes') }}" class="{{ set_active('world/recipes*') }}">Recipes</a></div>
        <div class="sidebar-item"><a href="{{ url('world/'. __('awards.awards')) }}" class="{{ set_active('world/'. __('awards.awards') .'*') }}">Badges </a></div>
        <div class="sidebar-item"><a href="{{ url('world/emotes') }}" class="{{ set_active('world/emotes*') }}">Emotes</a></div>
    </li>
</ul>