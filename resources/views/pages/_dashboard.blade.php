<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>

<!--character speechbubble-->
<div class="row charspeechbubble">
    <div class="col-md-4 col-12">
        @include('widgets._selected_character_homepage', ['character' => Auth::user()->settings->selectedCharacter, 'user' => Auth::user(), 'fullImage' => false])
    </div>
    <div class="col-md-8 col-12">
    <div class="yours messages">
    <div id="randomquote" class="message animated animatedFadeInUp fadeInUp">
 </div>
</div>
    </div>
</div>
<!--end character speechbubble-->



<!--character roster-->
<div class="dashboardcharroster">
@foreach(Auth::user()->characters()->take(4)->get()->chunk(4) as $chunk)
    <div class="row">
        @foreach($chunk as $charactera)
            <div class="col-md-3 col-12 text-center homepagechararosterbubble" style="position: relative; z-index: 1; text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">
                <div style="position:relative;z-index:3">
                    <a href="{{ $charactera->url }}"><img src="{{ $charactera->image->thumbnailUrl }}" class="img-thumbnail" alt="{{ $charactera->fullName }}" style="max-width:150px; height:auto; border-radius: 75px;" /></a>
                </div>
                <div class="mt-1">
                    <a href="{{ $charactera->url }}" class="h5 mb-0" style="position: relative; z-index: 1;"> @if( !$charactera->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $charactera->fullName }}</a>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
<div class="text-right"><h1><a href="{{ Auth::user()->url.'/characters' }}">View all...</a></h1></div>
</div>
<!-- end character roster-->

<hr>

<div class="row justify-contents-center">
    <!-- NEWS -->
    @include('widgets._news', ['textPreview' => true])
    <!-- END NEWS -->

    <!-- HIGHLIGHTS-->
    <div class="col-md-6 col-12 order-1 order-md-2">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" style="border-radius:15px;">
    <div class="carousel-item active">
        <a href="/news/9.september-newsletter-bughunt">
      <img class="d-block w-100" src="/files/eventpromos/bughuntpromo%20crunched.png" alt="First slide">
</a>
    </div>
    <div class="carousel-item">
        <a href="/info/yearsend23">
      <img class="d-block w-100" src="https://poffinsworld.com/files/eventpromos/yearsendpromo%20crunched.png" alt="Second slide">
</a>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    </div>
    <!-- END HIGHLIGHTS-->

    <!-- FEATURED CHAR-->
    <div class="col-md-3 col-12 order-3">
<div class="text-center"><h2 class="featuredchartitle">Featured Character</h2></div>
    <div>
        
        @if(isset($featured) && $featured)

            <div class="img-featuredchar">
                <a href="{{ $featured->url }}"><img src="{{ $featured->image->imageUrl }}" style="margin-left:auto;margin-right:auto;display:block;max-height:175px;" /></a>
            </div>
            <div class="mt-1 text-center">
                <a href="{{ $featured->url }}" class="h5 mb-0">@if(!$featured->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $featured->fullName }}</a>
            </div>
            <div class="small text-center">
                {!! $featured->displayOwner !!}
            </div>
        @else
            <p>There is no featured character.</p>
        @endif
        <p class="bg-success" align="center" style="padding:5px;border-radius:15px;">Gallery submissions with this character will earn x2 more steps for this month!</p>
</div>
    </div>
    <!-- END FEATURED CHAR-->
</div>

<hr>

<div class="row justify-contents-center">
    <div class="col-md-3 col-6 text-center">
        <h2>My account</h2>
        <img src="/files/SITEDECOR/normal%20myo.png">
        <div class="coolswagcontainer">
        <p style="font-size:20px;"><a href="{{ Auth::user()->url }}">✦ Profile ✦</a></p>
        <p style="font-size:20px;"><a href="/inventory">✦ Inventory ✦</a></p>
        <p style="font-size:20px;"><a href="/notifications">✦ Notification center ✦</a></p>
        <p style="font-size:20px;"><a href="/account/settings">✦ Settings ✦</a></p>
        </div>
    </div>
    <div class="col-md-3 col-6 text-center">
        <h2>Guidebook</h2>
        <img src="/files/SITEDECOR/guidebook.png">
        <div class="coolswagcontainer">
        <p style="font-size:20px;"><a href="/info/getstarted">✦ Getting started ✦</a></p>
        <p style="font-size:20px;"><a href="/info/design">✦ Design guide ✦</a></p>
        <p style="font-size:20px;">✦ Exploration guide ✦</p>
        <p style="font-size:20px;"><a href="/world">✦ Lore ✦</a></p>
        </div>
    </div>
    <div class="col-md-3 col-6 text-center">
        <h2>Create</h2>
        <img src="/files/SITEDECOR/create.png">
        <div class="coolswagcontainer">
        <p style="font-size:20px;"><a href="/gallery">✦ Submit to the gallery ✦</a></p>
        <p style="font-size:20px;"><a href="/prompts/prompts?prompt_category_id=3">✦ Weekly challenges ✦</a></p>
        <p style="font-size:20px;"><a href="/prompts/prompts?prompt_category_id=1">✦ Monthly prompt ✦</a></p>
        </div>
    </div>
    <div class="col-md-3 col-6 text-center">
        <h2>Activities</h2>
        <img src="/files/SITEDECOR/actvities.png">
        <div class="coolswagcontainer">
        <p style="font-size:20px;"><a href="/info/eventstage">✦ Current event ✦</a></p>
        <p style="font-size:20px;">✦ World map ✦</p>
        <p style="font-size:20px;"><a href="/shops">✦ Shops ✦</a></p>
        <p style="font-size:20px;"><a href="/dailies/1">✦ Checklist ✦</a></p>
        </div>
    </div>
</div>

<hr>

@include('widgets._affiliates', ['affiliates' => $affiliates, 'featured' => $featured_affiliates, 'open' => $open])


<script>

window.onload = choosequote;

var quote = [],
index = 0;
quote[0] = "    'みんなー チルノの算数教室、始まるよ' 'あたいみたいな天才目指して、頑張っていってね' キラキラダイヤモンド 輝く星のように 栄光 志望校なんとかして入ろう 天才秀才トップ目指して go, go ばーかばーか ばーかばーか ばーかばーか 'ちょっ、ちがっ、ばかじゃないもん' ばーかばーか ばーかばーか ばーかばーか 'ばかって言う方がばかなのよ' ばーかばーか ばーかばーか ばーかばーか 'なにようるさいわね、このばか！' ばーかばーか ばーかばーか 紅魔館からバスが出て 初めに三人乗りました 白玉楼で一人降りて半人だけ乗りました 八雲さん家で二人降りて 結局乗客合計何人だ？ 答えは答えは0人0人 なぜならなぜならそれは 幻想郷にバス無い ヤマオチ意味などないわ キャラクター立てばいいのよ 元気があればなんでも 1, 2, 9! くるくる時計の針 ぐるぐる頭回る だってつぶら目玉二つしかないのに 三本の針なんてちんぷんかん 次々問題出る まだまだ授業続く 凍る部屋の中 ひんやりした温度も 時間も気にせず ゆっくりしていってね！";
quote[1] = "<h3>Did you hear the one about the two guys on the moon? With the rock?</h3>";
quote[2] = "<h3>Kinda spacey today, huh?</h3>";
quote[3] = "<h3>I love exploding things with my mind!</h3>";
quote[4] = "<h3>You know, like nyah?</h3>";
quote[5] = "<h3>⬆⬆⬇⬇⬅→⬅→🅱🅰</h3>";
quote[6] = "<h3>[hands you a bug] [hands you a bug] [hands you a bug]</h3>";
quote[7] = "<h5>Have you heard of the critically acclaimed ARPG Poffins World which has an expanded free site that you can play through the entirety of prompts and events endlessly for free with no restrictions on participation? Now available on Lorekeeper and Discord! Sign up and enjoy the galaxy today!</h5>";



function choosequote() {
     var quoteNum = Math.floor(Math.random() * quote.length);
     document.getElementById("randomquote").innerHTML = quote[quoteNum];
}
</script>
