@extends('user.layouts')
@section('title')アカウント新規登録@endsection
@section('content')
<div class="main-container">
    <div class="event-container__inner">
        <div class="headline-en">Register</div>
        <div class="headline-ja">新規登録</div>
        <div class="login-wrapper">
            <div class="panel">
                <form action="{{ route('user.register') }}" method="POST">
                    @csrf
                    <!-- 入力フォーム -->
                    <output v-if="preview" class="login-wrapper__img-wrapper">
                        <img :src="preview" alt="" class="login-wrapper__img-preview">
                    </output>
                    <input type="file" @change="onFileChange" name="fileinfo">
                    <label for="name">名前</label>
                    <input type="text" id="name" v-model="registerForm.name">
                    <label for="email">メールアドレス</label>
                    <input type="text" id="email" v-model="registerForm.email">
                    <label for="phone">電話番号</label>
                    <input type="number" id="phone" v-model="registerForm.phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    <label for="home_circle">出身サークル</label>
                    <input type="text" id="home_circle" v-model="registerForm.home_circle">
                    <label for="birthday">生年月日</label>
                    <input type="date" id="birthday" v-model="registerForm.birthday">
                    <label for="sex">性別</label>
                    <select name="sex" id="sex" class="register-select-form" v-model="registerForm.sex">
                        <option value="">選択してください</option>
                        <option value="1">男性</option>
                        <option value="2">女性</option>
                        <option value="0">回答しない</option>
                    </select>
                    <label for="password">パスワード</label>
                    <input type="password" id="password" v-model="registerForm.password">
                    <label for="password_confirmation">パスワード確認用</label>
                    <input type="password" id="password-confirmation" v-model="registerForm.password_confirmation">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="button__join">新規登録</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <div>既にアカウントをお持ちの方は<a href="{{ route('user.login') }}">こちら</a></div>
        </div>
    </div>
</div>
@endsection
