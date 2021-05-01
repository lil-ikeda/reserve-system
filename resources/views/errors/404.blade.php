@extends('user.layouts')
@section('title')404エラー@endsection
@section('content')
<div id='app'>
    <div class="main-container">
        <div class="main-container__inner">
            <div class="error-page">
                <p class="code">404</p>
                <p class="desc">お探しのページは<br>見つかりませんでした。</p>
                <p class="code">🙇‍♂️</p>
            </div>
            <div class="d-flex justify-content-center font-weight-bold">
                <a href="{{ route('user.events.index') }}">トップページへ戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection