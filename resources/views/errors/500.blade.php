@extends('user.layouts')
@section('title')500エラー@endsection
@section('content')
<div id='app'>
    <div class="main-container">
        <div class="main-container__inner">
            <div class="error-page">
                <p class="code">500</p>
                <p class="desc">サーバーエラーが発生いたしました。</p>
                <p class="code">🙇‍♂️</p>
            </div>
            <div class="d-flex justify-content-center font-weight-bold">
                <a href="{{ route('user.events.index') }}">トップページへ戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection