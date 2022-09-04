<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>
<!--
<div class="card mb-4 timestamp">
    <div class="card-body">
        <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!}
    </div>
</div>
-->

<style>
    .sidebar{
        display:none;
    }

    .main-content{
        margin-left:10vw;
        background-color:var(--light);
        max-width:400px;
        height:fit-content;
        border-radius:10px;
    }

    .card, .card-body{
        background-color: rgba(0,0,0,0);
    }

</style>

<div class="row flex-column">
    <div class="row mt-5">
        <div class="col-md m-1">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('images/2-image.png') }}" alt="Account" />
                    <h5 class="card-title"><a href="{{ Auth::user()->url }}">Account</a></h5>
                </div>
                <!--
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ Auth::user()->url }}">Profile</a></li>
                    <li class="list-group-item"><a href="{{ url('account/settings') }}">User Settings</a></li>
                    <li class="list-group-item"><a href="{{ url('trades/open') }}">Trades</a></li>
                </ul>
                -->
            </div>
        </div>
        <div class="col-md m-1">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('images/3-image.png') }}" alt="Characters" />
                    <h5 class="card-title"><a href="{{ url('characters') }}">Characters</a></h5>
                </div>
                <!--
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('characters') }}">My Characters</a></li>
                    <li class="list-group-item"><a href="{{ url('characters/myos') }}">My MYO Slots</a></li>
                    <li class="list-group-item"><a href="{{ url('characters/transfers/incoming') }}">Character Transfers</a></li>
                </ul>
                -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md m-1">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('images/5-image.png') }}" alt="Inventory" />
                    <h5 class="card-title"><a href="{{ url('inventory') }}">Inventory</a></h5>
                </div>
                <!--
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('inventory') }}">My Inventory</a></li>
                    <li class="list-group-item"><a href="{{ Auth::user()->url . '/item-logs' }}">Item Logs</a></li>
                </ul>
                -->
            </div>
        </div>
        <div class="col-md m-1">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('images/7-image.png') }}" alt="Bank" />
                    <h5 class="card-title"><a href="{{ url('bank') }}">Bank</a></h5>
                </div>
                <!--
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('bank') }}">Bank</a></li>
                    <li class="list-group-item"><a href="{{ Auth::user()->url . '/currency-logs' }}">Currency Logs</a></li>
                </ul>
                -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md m-1">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('images/9-image.png') }}" />
                    <h5 class="card-title"><a href="{{ url('awardcase') }}">Awards</a></h5>
                </div>
                <!--
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('awardcase') }}">My Awards</a></li>
                    <li class="list-group-item"><a href="{{ Auth::user()->url . '/award-logs' }}">Award Logs</a></li>
                </ul>
                -->
            </div>
        </div>
        <div class="col-md m-1">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('images/10-image.png') }}" />
                    <h5 class="card-title"><a href="{{ url('research/unlocked') }}">Research</a></h5>
                </div>
                <!--
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ url('research/unlocked') }}">My Unlocked Research</a></li>
                    <li class="list-group-item"><a href="{{ url('research-trees') }}">Research Trees</a></li>
                    <li class="list-group-item"><a href="{{ url('research/history') }}">Research Logs</a></li>
                </ul>
                -->
            </div>
        </div>
    </div>
</div>
