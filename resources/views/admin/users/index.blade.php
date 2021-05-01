@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <p>ユーザー一覧</p>
            </div>
            <div class="card-body">
                @foreach ($users as $user)
                    <div class="d-flex border-bottom mb-3">
                        <div class="">
                            <img class="event-thumbnail-index" src="{{ asset($avators[$user->id]) }}" style="width: 50px; height: 50px;">
                        </div>
                        <ul class="list-group-flush">
                            <li class="list-group-item p-1 text-break">{{ $user->name }}</li>
                            <li class="list-group-item p-1 text-break">
                                @if($user->sex === config('const.sex.male.id'))
                                男性
                                @elseif($user->sex === config('const.sex.female.id'))
                                女性
                                @elseif($user->sex === config('const.sex.do_not_answer.id'))
                                回答しない
                                @endif
                            </li>
                            <li class="list-group-item p-1 text-break">{{ $homeCircles[$user->id] }}</li>
                            <li class="list-group-item p-1 text-break">{{ $user->phone }}</li>
                            <li class="list-group-item p-1 text-break">{{ $user->email }}</li>
                            <li class="list-group-item p-1 text-break">{{ $user->birthday }}</li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $users->links('pagination::default') }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
@stop

