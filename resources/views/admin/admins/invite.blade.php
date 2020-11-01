@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>ユーザー招待</h1> --}}
@stop

@section('content')
    <div class="container">
        <div class="col-6 offset-2">
            <div class="card">
                <div class="card-header">
                    ユーザー招待
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.send.invitemail') }}" method="POST" class="d-flex justify-content-between">
                        @csrf
                        @method('POST')
                        <input type="email" name="email" placeholder="tanaka@example.com" style="width: 70%">
                        <button type="submit" class="btn btn-info">招待する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script></script>
@stop
