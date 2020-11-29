@extends('layouts.app')

@section('title') Credits @endsection

@section('content')
{!! breadcrumbs(['Credits' => url('credits') ]) !!}
<h1>Credits</h1>

<div class="site-page-content parsed-text">
    {!! $credits->parsed_text !!}
</div>

<hr>

<h4 class="mb-0">Extensions</h4>
<p class="mb-2">These extensions were coded by the Lorekeeper community, and are now a part of core Lorekeeper.</p>
<div class="extensions">
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Stacked_Inventories"><strong>Stacked Inventories</strong></a> by <a href="https://github.com/Draginraptor">Draginraptor</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Submission_Addons"><strong>Submission Addons</strong></a> by <a href="https://github.com/itinerare">itinerare</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Character_Items"><strong>Character Items</strong></a> by <a href="https://github.com/itinerare">itinerare</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Bootstrap_Tables"><strong>Bootstrap Tables</strong></a> by <a href="https://github.com/preimpression">Preimpression</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Watermarking"><strong>Watermarking</strong></a> by <a href="https://github.com/itinerare">itinerare</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Separate_Prompts"><strong>Separate Prompts</strong></a> by <a href="https://github.com/itinerare">itinerare</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Comments"><strong>Comments</strong></a> by <a href="https://github.com/preimpression">Preimpression</a> & <a href="https://github.com/Ne-wt">Ne-wt</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Reports"><strong>Reports</strong></a> by <a href="https://github.com/Ne-wt">Ne-wt</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Masterlist_Sublists"><strong>Masterlist Sublists</strong></a> by <a href="https://github.com/junijwi">Junijwi</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:MYO_Item_Tag"><strong>MYO Item Tag</strong></a> by <a href="https://github.com/junijwi">Junijwi</a>
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:User_Transfer_Reasons"><strong>User Transfer Reasons</strong></a> by <a href="https://github.com/snupsplus">Snupsplus</a>
    </p>
    <p class="mb-0">
        <strong>Extension Tracker</strong> by <a href="https://github.com/preimpression">Preimpression</a> (This page/the section below!)
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Navbar_News_Notif"><strong>Navbar News Notif</strong></a> by <a href="https://github.com/junijwi">Junijwi</a> ({{ Config::get('navbar_news_notif') ? 'Enabled' : 'Disabled' }})
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Species_Trait_Index"><strong>Species Trait Index</strong></a> by <a href="https://github.com/itinerare">itinerare</a> ({{ Config::get('species_trait_index') ? 'Enabled' : 'Disabled' }})
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Character_Status_Badges"><strong>Character Status Badges</strong></a> by <a href="https://github.com/junijwi">Junijwi</a> ({{ Config::get('character_status_badges') ? 'Enabled' : 'Disabled' }})
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Character_TH_Profile_Link"><strong>Character TH Profile Link</strong></a> by <a href="https://github.com/junijwi">Junijwi</a> ({{ Config::get('character_TH_profile_link') ? 'Enabled' : 'Disabled' }})
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Design_Update_Voting"><strong>Design Update Voting</strong></a> by <a href="https://github.com/itinerare">itinerare</a> ({{ Config::get('design_update_voting') ? 'Enabled' : 'Disabled' }})
    </p>
    <p class="mb-0">
        <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:Item_Entry_Expansion"><strong>Item Entry Expansion</strong></a> by <a href="https://github.com/itinerare">itinerare</a> ({{ Config::get('design_update_voting.extra_fields') ? 'Enabled' : 'Disabled' }}/{{ Config::get('design_update_voting.resale_function') ? 'Enabled' : 'Disabled' }})
    </p>
</div>

<hr/>
<p class="mb-2">These extensions have been added to this site.</p>

@if($extensions->count())
    <div class="extensions">
        @foreach($extensions as $extension)
            <p class="mb-0">
                <a href="http://wiki.lorekeeper.me/index.php?title=Extensions:{{ $extension->wiki_key }}">
                    <strong>{{ str_replace('_',' ',$extension->wiki_key) }}</strong>
                    <small>v. {{ $extension->version }}</small>
                </a>
                by
                <?php $extension->array = json_decode($extension->creators,true); $extension->end = end($extension->array); ?>
                @foreach(json_decode($extension->creators,true) as $name => $url)
                    <a href="{{ $url }}">{{ $name }}</a>{{$extension->end != $extension->array[$name] ? ',' : '' }}
                @endforeach
            </p>
        @endforeach
    </div>
@else
    <p>No extensions found.</p>
@endif

@endsection
