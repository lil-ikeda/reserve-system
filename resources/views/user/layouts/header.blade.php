<header class="header">
  <div class="header__wrapper">
    <a class="text-decoration-none font-white" href="{{ route('users.events.index') }}">
      <span class="header__wrapper--title">
        <span>ロゴ</span>
      </span>
    </a>
    @auth
      <div class="header__link" v-if='isLogin'>
        <a href="{{ route('users.logout') }}">ログアウト</a>
      </div>
    @endauth
    @guest
      <div class="header__link" v-else>
          <a href="{{ route('users.login') }}">ログイン</a>
      </div>
    @endguest
  </div>
</header>