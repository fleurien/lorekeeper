<ul>
    <li class="sidebar-header"><a href="{{ $user->url }}" class="card-link">{{ Illuminate\Support\Str::limit($user->name, 10, $end = '...') }}</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Gallery</div>
        <div class="sidebar-item"><a href="{{ $user->url . '/gallery' }}" class="{{ set_active('user/' . $user->name . '/gallery*') }}">Gallery</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/favorites' }}" class="{{ set_active('user/' . $user->name . '/favorites*') }}">Favorites</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/favorites/own-characters' }}" class="{{ set_active('user/' . $user->name . '/favorites/own-characters*') }}">Own Character Favorites</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">User</div>
        <div class="sidebar-item"><a href="{{ $user->url . '/aliases' }}" class="{{ set_active('user/' . $user->name . '/aliases*') }}">Aliases</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/characters' }}" class="{{ set_active('user/' . $user->name . '/characters*') }}">Characters</a></div>
        @if (isset($sublists) && $sublists->count() > 0)
            @foreach ($sublists as $sublist)
                <div class="sidebar-item"><a href="{{ $user->url . '/sublist/' . $sublist->key }}" class="{{ set_active('user/' . $user->name . '/sublist/' . $sublist->key) }}">{{ $sublist->name }}</a></div>
            @endforeach
        @endif
<<<<<<< HEAD
        <div class="sidebar-item"><a href="{{ $user->url.'/myos' }}" class="{{ set_active('user/'.$user->name.'/myos*') }}">MYO Slots</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/breeding-permissions' }}" class="{{ set_active('user/'.$user->name.'/breeding-permissions*') }}">Breeding Permissions</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/inventory' }}" class="{{ set_active('user/'.$user->name.'/inventory*') }}">Inventory</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/awardcase' }}" class="{{ set_active('user/'.$user->name.'/awardcase*') }}">Awards</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/bank' }}" class="{{ set_active('user/'.$user->name.'/bank*') }}">Bank</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/level' }}" class="{{ set_active('user/'.$user->name.'/level*') }}">Level Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/pets' }}" class="{{ set_active('user/'.$user->name.'/pets*') }}">Pets</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/armoury' }}" class="{{ set_active('user/'.$user->name.'/armoury*') }}">Armoury</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">History</div>
        <div class="sidebar-item"><a href="{{ $user->url.'/ownership' }}" class="{{ $user->url.'/ownership*' }}">Ownership History</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/item-logs' }}" class="{{ $user->url.'/currency-logs*' }}">Item Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/currency-logs' }}" class="{{ set_active($user->url.'/currency-logs*') }}">Currency Logs</a></div>
<<<<<<< HEAD
        <div class="sidebar-item"><a href="{{ $user->url.'/award-logs' }}" class="{{ $user->url.'/award-logs*' }}">Award Logs</a></div>
=======
        <div class="sidebar-item"><a href="{{ $user->url.'/pet-logs' }}" class="{{ set_active($user->url.'/pet-logs*') }}">Pet Logs</a></div>
>>>>>>> a065cf0f0bd9f09fb40f23bd38fab2b604d1cd0c
        <div class="sidebar-item"><a href="{{ $user->url.'/submissions' }}" class="{{ set_active($user->url.'/submissions*') }}">Submissions</a></div>
<<<<<<< HEAD
=======
        <div class="sidebar-item"><a href="{{ $user->url . '/myos' }}" class="{{ set_active('user/' . $user->name . '/myos*') }}">MYO Slots</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/inventory' }}" class="{{ set_active('user/' . $user->name . '/inventory*') }}">Inventory</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/bank' }}" class="{{ set_active('user/' . $user->name . '/bank*') }}">Bank</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">History</div>
        <div class="sidebar-item"><a href="{{ $user->url . '/ownership' }}" class="{{ $user->url . '/ownership*' }}">Ownership History</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/item-logs' }}" class="{{ $user->url . '/currency-logs*' }}">Item Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/currency-logs' }}" class="{{ set_active($user->url . '/currency-logs*') }}">Currency Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url . '/submissions' }}" class="{{ set_active($user->url . '/submissions*') }}">Submissions</a></div>
>>>>>>> 7338c1a73a47b7c9d106c5d5ec9f96a7d72e9c56
=======
        <div class="sidebar-item"><a href="{{ $user->url.'/collection-logs' }}" class="{{ set_active($user->url.'/collection-logs*') }}">Collection Logs</a></div>
>>>>>>> 56998441bf67d7ea4ee34db330c0f335d16db3e6
    </li>

    @if (Auth::check() && Auth::user()->hasPower('edit_user_info'))
        <li class="sidebar-section">
            <div class="sidebar-section-header">Admin</div>
            <div class="sidebar-item"><a href="{{ $user->adminUrl }}">Edit User</a></div>
        </li>
    @endif
</ul>
