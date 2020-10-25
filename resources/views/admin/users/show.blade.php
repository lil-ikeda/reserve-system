@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>マイページ</h1>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $user->name }}
            </div>
            <div class="card-body">
                <div class="">
                    <strong>メールアドレス：　</strong>{{ $user->email }}
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onSubmit="return deleteCheck()">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-outline-danger" >
                アカウントを削除する
            </button>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script></script>
@stop
