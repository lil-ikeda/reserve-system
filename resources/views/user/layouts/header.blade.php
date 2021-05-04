<header class="header">
    <div class="header__wrapper">
        <a class="text-decoration-none font-white" href="{{ route('user.events.index') }}">
            <span class="header__wrapper--title">
                <img src="/img/header-logo.png" style="width: 120px;">
            </span>
        </a>

        @auth('user')
        <div class="header__link">
            <a class="" href="{{ route('user.logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">ログアウト
            </a>
            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            {{-- TODO: アイコンクリックでユーザーメニューを表示させる --}}
            @if(Auth::user()->avatar)
                <img src="{{ config('const.s3').Auth::user()->avatar }}" style="width: 40px; border-radius: 50%;">
            @else
                <span style="font-size: 30px;">😋</span>
            @endif
        </div>
        @endauth

        @guest('user')
        <div class="header__link" v-else>
            <a href="{{ route('user.login') }}">ログイン</a>
        </div>
        @endguest
    </div>
</header>