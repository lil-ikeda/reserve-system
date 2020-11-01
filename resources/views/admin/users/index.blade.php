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
                    <p>ユーザー一覧</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>アイコン</th>
                                    <th>ユーザー名</th>
                                    <th>性別</th>
                                    <th>メールアドレス</th>
                                    <th>生年月日</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><img style="width: 37px; height: 37px;" src="{{ asset($avators[$user->id]) }}" alt=""></td>
                                    <td><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></td>
                                    <td>{{ $sexes[$user->id] }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->birthday }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
{{--    <link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

