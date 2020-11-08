@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>ユーザー詳細</h1>
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
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
