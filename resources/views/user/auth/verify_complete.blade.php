@extends('user.layouts')
@section('title')本人確認完了@endsection
@section('content')
<div id="app">
    <div class="main-container">
        <div class="main-container__inner">
            <div class="entry-headline">本人確認完了🎉</div>
            <div class="event-info__entry">
                {{-- <div class="confirm-mail-icon">
                    <img src="/img/paper-plane.png">
                </div> --}}
                <div>
                    ご登録いただきありがとうございます。<br>
                    メールアドレスの認証が完了しました！
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5 font-weight-bold">
            <div class="">
                <a href="{{ route('user.events.index') }}">トップページへ戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection