<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>

<!--
<div class="card mb-4 timestamp">
    <div class="card-body">
        <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!}
    </div>
</div>
-->

<div class="temp">

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
            <a href="{{ Auth::user()->url }}"><img src="{{ asset('images/account.png') }}" alt="Account" /></a>
            <a href="{{ Auth::user()->url }}"><h5 class="card-title">Account</h5></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
            <a href="{{ url('characters') }}"><img src="{{ asset('images/characters.png') }}" alt="Characters" /></a>
            <a href="{{ url('characters') }}"><h5 class="card-title">Characters</h5></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
            <a href="{{ url('inventory') }}"><img src="{{ asset('images/inventory.png') }}" alt="Inventory" /></a>
            <a href="{{ url('inventory') }}"><h5 class="card-title">Inventory</h5></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
            <a href="{{ url('bank') }}"><img src="{{ asset('images/currency.png') }}" alt="Bank" /></a>
            <a href="{{ url('bank') }}"><h5 class="card-title">Bank</h5></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-12">
            <div class="card-body text-center">
            <a href="{{ url('awardcase') }}"><img src="{{ asset('images/awards.png') }}" /></a>
            <a href="{{ url('awardcase') }}"><h5 class="card-title">Awards</h5></a>
            </div>
        </div>
    </div>
</div>

</div>
@include('widgets._affiliates', ['affiliates' => $affiliates, 'featured' => $featured_affiliates, 'open' => $open])