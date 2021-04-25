@extends('user.layouts')
@section('title')メール確認@endsection
@section('content')
<div id="app">
    <div class="main-container">
        <div class="main-container__inner">
            <div class="entry-headline">メール確認をお願いします🙇‍♂️</div>
            <div class="event-info__entry">
                <div>
                    アカウント登録はまだ完了していません。<br>
                    メールに記載されたリンクをクリックしてアカウント登録を完了してください。
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <form class="d-inline" method="POST" action="{{ route('user.verification.resend') }}">
                @csrf
                メールが届かない場合は
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline font-weight-bold">こちら</button>
                から確認メールの再送をしてください。
            </form>
        </div>
        <div class="d-flex justify-content-center mt-5 font-weight-bold">
            <div class="">
                <a href="{{ route('user.events.index') }}">トップページへ戻る</a>
            </div>
        </div>  
    </div>
</div>
@endsection