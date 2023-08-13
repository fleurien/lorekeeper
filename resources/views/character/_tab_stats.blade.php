<div class="row">
    <div class="col-lg-3 col-4"><h5>Owner</h5></div>
    <div class="col-lg-9 col-8">{!! $character->displayOwner !!}</div>
</div>
@if(!$character->is_myo_slot)
    <div class="row">
        <div class="col-lg-3 col-4"><h5>Category</h5></div>
        <div class="col-lg-9 col-8">{!! $character->category->displayName !!}</div>
    </div>
@endif
<div class="row">
    <div class="col-lg-3 col-4"><h5 class="mb-0">Created</h5></div>
    <div class="col-lg-9 col-8">{!! format_date($character->created_at) !!}</div>
</div>

<hr />

{{-- Bio --}}
@if(Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
    <div class="text-right mb-2">
        <a href="{{ $character->url . '/profile/edit' }}" class="btn btn-outline-info btn-sm"><i class="fas fa-cog"></i> Edit Profile</a>
    </div>
@endif
@if($character->profile->parsed_text)
    <div class="card mb-3">
        <div class="card-body parsed-text">
                {!! $character->profile->parsed_text !!}
        </div>
    </div>
@endif



<h5><i class="text-{{ $character->is_giftable ? 'success far fa-circle' : 'danger fas fa-times'  }} fa-fw mr-2"></i> {{ $character->is_giftable ? 'Can' : 'Cannot'  }} be gifted</h5>
<h5><i class="text-{{ $character->is_tradeable ? 'success far fa-circle' : 'danger fas fa-times'  }} fa-fw mr-2"></i> {{ $character->is_tradeable ? 'Can' : 'Cannot'  }} be traded</h5>
<h5><i class="text-{{ $character->is_sellable ? 'success far fa-circle' : 'danger fas fa-times'  }} fa-fw mr-2"></i> {{ $character->is_sellable ? 'Can' : 'Cannot'  }} be sold</h5>
<div class="row">
    <div class="col-lg-3 col-4"><h5>Sale Value</h5></div>
    <div class="col-lg-9 col-8">{{ Config::get('lorekeeper.settings.currency_symbol') }}{{ $character->sale_value }}</div>
</div>
@if($character->transferrable_at && $character->transferrable_at->isFuture())
    <div class="row">
        <div class="col-lg-3 col-4"><h5>Cooldown</h5></div>
        <div class="col-lg-9 col-8">Cannot be transferred until {!! format_date($character->transferrable_at) !!}</div>
    </div>
@endif
@if(Auth::check() && Auth::user()->hasPower('manage_characters'))
    <div class="mt-3">
        <a href="#" class="btn btn-outline-info btn-sm edit-stats" data-{{ $character->is_myo_slot ? 'id' : 'slug' }}="{{ $character->is_myo_slot ? $character->id : $character->slug }}"><i class="fas fa-cog"></i> Edit</a> 
        <a class="float-right" href="{{ url('reports/new?url=') . $character->url . '/profile' }}"><i class="fas fa-exclamation-triangle" data-toggle="tooltip" title="Click here to report this character's profile." style="opacity: 50%;"></i></a>
    </div>
@endif

