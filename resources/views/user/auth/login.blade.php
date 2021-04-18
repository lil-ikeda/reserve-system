@extends('user.layouts')
@section('title')ログイン@endsection
@section('content')
<div id="app"></div>
    <div class="main-container">
        <div class="event-container__inner">
          <div class="headline-en">Login</div>
          <div class="headline-ja">ログイン</div>
            <div class="login-wrapper">
                <!-- ログイン -->
                <div class="panel">
                    <!-- <form :action="propLoginRoute" method="post"> -->
                    <form action="{{ route('user.login') }}" method="POST">
                        @csrf
                        @error('failed')
                            <span class="invalid-feedback" role="alert">
                              {{ $message }}
                            </span>
                        @enderror
                        <!-- 入力フォーム -->
                        <label for="email">メールアドレス</label>
                        <input name="email" type="text" id="email" class="@error('email') is-invalid @enderror">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('email') }}
                            </span>
                        @enderror
                        <label for="password">パスワード</label>
                        <input name="password" type="password" id="password" class="@error('password') is-invalid @enderror">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('password') }}
                            </span>
                        @enderror
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="button__join">ログイン</button>
                        </div>
                    </form>
                </div>
              </div>
              <div class="d-flex justify-content-center mt-5">
                  <div>アカウントをお持ちでない方は<a href="{{ route('user.register') }}">こちら</a></div>
              </div>
        </div>
    </div>
@endsection