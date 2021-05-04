<header class="header">
    <div class="header__wrapper">
        {{-- ロゴ --}}
        <a class="text-decoration-none font-white" href="{{ route('user.events.index') }}">
            <span class="header__wrapper--title">
                <img src="/img/header-logo.png" style="width: 120px;">
            </span>
        </a>

        {{-- ユーザーアイコン --}}
        @auth('user')
        <input type="checkbox" class="open-sidebar" id="open-sidebar">
        <div class="header__link">
            @if(Auth::user()->avatar)
                <label for="open-sidebar">
                    <img id="sidebar-toggle" src="{{ config('const.s3').Auth::user()->avatar }}" style="width: 40px; border-radius: 50%;">
                </label>
            @else
                <label for="open-sidebar">
                    <span id="sidebar-toggle" style="font-size: 30px;">😋</span>
                </label>
            @endif
        </div>
        @endauth
        
        {{-- ログインリンク --}}
        @guest('user')
        <div class="header__link">
            <a href="{{ route('user.login') }}">ログイン</a>
        </div>
        @endguest

        {{-- sidebar --}}
        <label class="sidebar-overray" for="open-sidebar"></label>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <ul class="inner">
                <li class="title">Menu</li>
                <li class="d-flex justify-content-between">
                    <a class="d-block" href="#">プロフィール</a>
                </li>
                <li class="d-flex justify-content-between">
                    <a class="d-block" href="{{ route('user.logout') }}"
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">ログアウト
                    </a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</header>