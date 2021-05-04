@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>ユーザー招待</h1> --}}
@stop

@section('content')
    {{-- 正常系フラッシュ --}}
    @if (session('flash_message'))
        <div class="alert alert-primary" role="alert">
            {{ session('flash_message')}}
        </div>
    @endif
    {{-- 異常系フラッシュ --}}
    @if (session('error_message'))
        <div class="alert alert-danger" role="alert">
            {{ session('flash_message')}}
        </div>
    @endif
    <div class="container">
        <div class="col-md-6 col-sm-12 offset-md-2">
            <div class="card">
                <div class="card-header">
                    ユーザー招待
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.send.invitemail') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="email">メールアドレス <span class="badge badge-danger">必須</span></label>
                            <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="tanaka@example.com">
                            @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary d-block mt-3" role="button">招待する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
@stop

@section('js')
    <script></script>
@stop
