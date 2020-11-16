@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <!-- Style -->
    {{--    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">--}}
    <div class="container">
        <div class="">
            <div class="card">
                <div class="card-header">
                    <p>管理者一覧</p>
                </div>
                <div class="card-body p-0">
                    @foreach($admins as $admin)
                        <div class="">
                            {{ $admin->name }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

