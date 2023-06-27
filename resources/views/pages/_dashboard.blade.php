<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>
<div class="card mb-4 timestamp">
    <div class="card-body">
        <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!}
    </div>
</div>

<div class="row">
    <div class="col-4">
        @include('widgets._selected_character_homepage', ['character' => Auth::user()->settings->selectedCharacter, 'user' => Auth::user(), 'fullImage' => false])
    </div>
    <div class="col-8">
    <div class="yours messages">
    <div class="message animated animatedFadeInUp fadeInUp">
    "みんなー チルノの算数教室、始まるよ"
"あたいみたいな天才目指して、頑張っていってね"
キラキラダイヤモンド 輝く星のように
栄光 志望校なんとかして入ろう
天才秀才トップ目指して go, go
ばーかばーか ばーかばーか ばーかばーか
"ちょっ、ちがっ、ばかじゃないもん"
ばーかばーか ばーかばーか ばーかばーか
"ばかって言う方がばかなのよ"
ばーかばーか ばーかばーか ばーかばーか
"なにようるさいわね、このばか！"
ばーかばーか ばーかばーか
紅魔館からバスが出て 初めに三人乗りました
白玉楼で一人降りて半人だけ乗りました
八雲さん家で二人降りて 結局乗客合計何人だ？
答えは答えは0人0人 なぜならなぜならそれは
幻想郷にバス無い
ヤマオチ意味などないわ キャラクター立てばいいのよ
元気があればなんでも
1, 2, 9!
くるくる時計の針 ぐるぐる頭回る
だってつぶら目玉二つしかないのに
三本の針なんてちんぷんかん
次々問題出る まだまだ授業続く
凍る部屋の中
ひんやりした温度も 時間も気にせず
ゆっくりしていってね！
    </div>
</div>
    </div>
</div>
<img src="/files/divider2.png" style="display: block; margin-left: auto; margin-right: auto;">
<div>
@foreach(Auth::user()->characters()->take(4)->get()->chunk(4) as $chunk)
    <div class="row mb-4">
        @foreach($chunk as $charactera)
            <div class="col-md-3 col-6 text-center" style="position: relative; z-index: 1; text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">
                <div>
                    <a href="{{ $charactera->url }}"><img src="{{ $charactera->image->thumbnailUrl }}" class="img-thumbnail" alt="{{ $charactera->fullName }}" /></a>
                </div>
                <div class="mt-1">
                    <a href="{{ $charactera->url }}" class="h5 mb-0" style="position: relative; z-index: 1;"> @if( !$charactera->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $charactera->fullName }}</a>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
<img src="/files/divider3.png" style="display: block; position: relative; bottom: 75px; margin-left: auto; z-index: 0;">
<div class="text-right"><a href="{{ Auth::user()->url.'/characters' }}">View all...</a></div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('images/account.png') }}" alt="Account" />
                <h5 class="card-title">Account</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ Auth::user()->url }}">Profile</a></li>
                <li class="list-group-item"><a href="{{ url('account/settings') }}">User Settings</a></li>
                <li class="list-group-item"><a href="{{ url('trades/open') }}">Trades</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('images/characters.png') }}" alt="Characters" />
                <h5 class="card-title">Characters</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('characters') }}">My Characters</a></li>
                <li class="list-group-item"><a href="{{ url('characters/myos') }}">My MYO Slots</a></li>
                <li class="list-group-item"><a href="{{ url('characters/transfers/incoming') }}">Character Transfers</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('images/inventory.png') }}" alt="Inventory" />
                <h5 class="card-title">Inventory</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('inventory') }}">My Inventory</a></li>
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/item-logs' }}">Item Logs</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('images/currency.png') }}" alt="Bank" />
                <h5 class="card-title">Bank</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('bank') }}">Bank</a></li>
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/currency-logs' }}">Currency Logs</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-12">
            <div class="card-body text-center">
                <img src="{{ asset('images/awards.png') }}" />
                <h5 class="card-title">Awards</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('awardcase') }}">My Awards</a></li>
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/award-logs' }}">Award Logs</a></li>
            </ul>
        </div>
    </div>
</div>
