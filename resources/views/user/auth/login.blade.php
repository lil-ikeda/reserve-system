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
                    <form action="{{ route('user.login') }}" method="POST">
                        @csrf
                        <!-- 入力フォーム -->
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input name="email" type="text" id="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="tanaka@example.com">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('email') }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" style="margin-bottom: 0;">パスワード</label>
                            <span class="text-black-50 d-block"> ※8文字以上の半角英数字・記号</span>
                            <input name="password" type="password" id="password" class="@error('password') is-invalid @enderror" placeholder="password" autocomplete="off">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('password') }}
                            </span>
                            @enderror
                        </div>
                        @error('failed')
                            <span class="invalid-feedback d-block" role="alert" >
                              {{ $message }}
                            </span>
                        @enderror
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="button__join">ログイン</button>
                        </div>
                    </form>
                </div>
              </div>
              <div class="d-flex justify-content-center mt-5">
                  <div>アカウントをお持ちでない方は<a href="{{ route('user.register') }}" class="font-weight-bold">こちら</a></div>
              </div>
        </div>
    </div>
@endsection
