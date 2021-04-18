<header class="header">
  <div class="header__wrapper">
    <a class="text-decoration-none font-white" href="{{ route('user.events.index') }}">
      <span class="header__wrapper--title">
        <span>ロゴ</span>
      </span>
    </a>

    @auth('user')
      <div class="header__link" v-if='isLogin'>
        <a class="" href="{{ route('user.logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">ログアウト
        </a>
        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

      </div>
    @endauth

    @guest('user')
      <div class="header__link" v-else>
          <a href="{{ route('user.login') }}">ログイン</a>
      </div>
    @endguest
  </div>
</header>