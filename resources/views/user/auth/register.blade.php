@extends('user.layouts')
@section('title')アカウント新規登録@endsection
@section('content')
<div id="app">
    <div class="main-container">
        @if ($errors->any())
        <div class=“errors”>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
        <Register
            prop-register-route="{{ route('user.register') }}"
            csrf-token="{{ csrf_token() }}"
            :prop-circles='@json($circles)'
        >
        </Register>
        <div class="d-flex justify-content-center mt-5">
            <div>既にアカウントをお持ちの方は<a href="{{ route('user.login') }}">こちら</a></div>
        </div>
    </div>
</div>
@endsection
