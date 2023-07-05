<nav class="navbar navbar-expand-md navbar-dark bg-dark" id="headerNav">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    @if(Auth::check() && Auth::user()->is_news_unread && Config::get('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex" href="{{ url('news') }}"><strong>News</strong><img src="http://localhost/files/new.gif" class="newnotif"></a>
                    @else
                        <a class="nav-link" href="{{ url('news') }}">News</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if(Auth::check() && Auth::user()->is_sales_unread && Config::get('lorekeeper.extensions.navbar_news_notif'))
                    <a id="salesDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Sales <img src="http://localhost/files/new.gif" class="newnotif">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="salesDropdown" style="left: 13%;">
                        <a class="dropdown-item" href="{{ url('sales') }}">
                        <i class="fa-solid fa-money-check-dollar"></i> Sales<img src="http://localhost/files/new.gif" class="newnotif">
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('raffles') }}">
                        <i class="fa-solid fa-dice"></i> Raffles
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/trades/listings">
                        <i class="fa-solid fa-right-left"></i> Trades
                        </a>
                    </div>
                    @else
                    <a id="salesDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Sales
                    </a>
                    <div class="dropdown-menu" aria-labelledby="salesDropdown" style="left: 13%;">
                        <a class="dropdown-item" href="{{ url('sales') }}">
                        <i class="fa-solid fa-money-check-dollar"></i> Sales
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('raffles') }}">
                        <i class="fa-solid fa-dice"></i> Raffles
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/trades/listings">
                        <i class="fa-solid fa-right-left"></i> Trades
                        </a>
                    </div>
                    @endif
                </li>
                <li style="border-left:2px solid #ffffff8c;height:25px;margin-top: 5px;"></li>
                <li class="nav-item dropdown">
                    <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Browse
                    </a>

                    <div class="dropdown-menu" aria-labelledby="browseDropdown">
                        <a class="dropdown-item" href="{{ url('masterlist') }}">
                        <i class="fa-solid fa-user-group"></i> Masterlist
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('gallery') }}">
                        <i class="fa-solid fa-images"></i> Gallery
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('forum') }}">
                        <i class="fa-solid fa-comment-dots"></i> Forums
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="exploreDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Explore
                    </a>

                    <div class="dropdown-menu" aria-labelledby="exploreDropdown">
                        <a class="dropdown-item" href="templink">
                        <i class="fa-solid fa-map-location-dot"></i> Hub map
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="templink">
                        <i class="fa-solid fa-signs-post"></i> Go exploring
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('shops') }}">
                        <i class="fa-solid fa-shop"></i> Shops
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="templink">
                        <i class="fa-solid fa-book-atlas"></i> Lore
                        </a>
                        <a class="dropdown-item" href="{{ url('foraging') }}">
                            Foraging
                        </a>
                        <a class="dropdown-item" href="{{ url('fetch') }}">
                            Fetch Quests
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="guidesDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Guides
                    </a>

                    <div class="dropdown-menu" aria-labelledby="guidesDropdown">
                        <a class="dropdown-item" href="templink">
                        <i class="fa-solid fa-star fa-spin"></i> Getting started
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="templink">
                        <i class="fa-solid fa-paintbrush"></i></i> MYO Guide
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('shops') }}">
                        <i class="fa-solid fa-binoculars"></i> Explore guide
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('reports') }}">
                        <i class="fa-solid fa-suitcase-medical"></i></i> Helpdesk & Bug reports
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="eventDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Events
                    </a>

                    <div class="dropdown-menu" aria-labelledby="eventDropdown">
                        <a class="dropdown-item" href="templink">
                        <i class="fa-solid fa-gifts"></i> Event stage
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                @if(Auth::user()->isStaff)

<li class="nav-item d-flex">

  <a class="nav-link position-relative display-inline-block" href="{{ url('admin') }}"><i class="fas fa-crown"></i>

    @if (Auth::user()->hasAdminNotification(Auth::user()))

      <span class="position-absolute rounded-circle bg-danger text-light" style="top: -2px; right: -5px; padding: 1px 6px 1px 6px; font-weight:bold; font-size: 0.8em; box-shadow: 1px 1px 1px rgba(0,0,0,.25);">

        {{ Auth::user()->hasAdminNotification(Auth::user()) }}

      </span>

  @endif

  </a>

</li>

@endif
                    @if(Auth::user()->notifications_unread)
                        <li class="nav-item">
                            <a class="nav-link btn btn-secondary btn-sm" href="{{ url('notifications') }}"><span class="fas fa-envelope"></span> {{ Auth::user()->notifications_unread }}</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ Auth::user()->url }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('notifications') }}">
                                Notifications
                            </a>
                            <a class="dropdown-item" href="{{ Auth::user()->url }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ url('account/settings') }}">
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('characters') }}">
                                My Characters
                            </a>
                            <a class="dropdown-item" href="{{ url('inventory') }}">
                                Inventory
                            </a>
                            <a class="dropdown-item" href="{{ url('bank') }}">
                                Bank
                            </a>
                            <a class="dropdown-item" href="{{ url('account/bookmarks') }}">
                                Bookmarks
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('submissions') }}">
                                Prompt Submissions
                            </a>
                            <a class="dropdown-item" href="{{ url('designs') }}">
                                Design Approvals
                            </a>
                            <a class="dropdown-item" href="{{ url('characters/transfers/incoming') }}">
                                Character Transfers
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
