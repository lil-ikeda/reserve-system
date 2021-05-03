@extends('user.layouts')
@section('title')アカウント新規登録@endsection
@section('content')
<div id="app">
    <div class="main-container">
        <Register
            prop-register-route="{{ route('user.register') }}"
            prop-login-route="{{ route('user.login') }}"
            csrf-token="{{ csrf_token() }}"
            :prop-circles='@json($circles)'
            :prop-errors='@json($errors->default)'
            :prop-old='@json(old())'
        >
        </Register>
        <div class="d-flex justify-content-center mt-5">
            <div>既にアカウントをお持ちの方は<a href="{{ route('user.login') }}" class="font-weight-bold">こちら</a></div>
        </div>
    </div>
</div>
@endsection
