@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>ユーザー招待</h1> --}}
@stop

@section('content')
    <div class="container">
        <div class="col-md-6 col-sm-12 offset-md-2">
            <div class="card">
                <div class="card-header">
                    ユーザー招待
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.send.invitemail') }}" method="POST" class="d-flex justify-content-between">
                        @csrf
                        @method('POST')
                        <input type="email" name="email" placeholder="tanaka@example.com" style="width: 70%">
                        <button type="submit" class="btn btn-info">送信</button>
                    </form>
                </div>
            </div>
        </div>
{{--        <form href="{{ route('admin.admins.paypay') }}" method="POST">--}}
{{--            @csrf--}}
{{--            @method('POST')--}}
{{--            <button type="submit">paypay</button>--}}
{{--        </form>--}}
        {{-- <a href="{{ route('admin.admins.paypay') }}">paypay</a> --}}
    </div>
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
