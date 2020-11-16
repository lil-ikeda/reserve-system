@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <!-- Style -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <div class="container">
        <div class="col-md-7 offset-md-2 col-sm-12">
            <h3>イベント一覧</h3>
            @foreach ($events as $event)
                <a href="{{ route('admin.events.show', $event->id) }}" class="text-decoration-none">
                    <div class="card">
                        <p class="card-header">{{ $event->name }}</p>
                        <div class="card-body">
                            <div class="">
                                @if (isset($event->image))
                                    <img class="event-thumbnail-index" src="{{ config('const.s3') . $event->image }}">
                                @else
                                    <img class="event-thumbnail-index" src="{{ asset('img/noimage.png') }}">
                                @endif
                            </div>
                            <ul class="mt-3">
                                <li>日程：{{ $event->date }}</li>
                                <li>時間：{{ $event->open_time }} - {{ $event->close_time }}</li>
                                <li>場所：{{ $event->place }}</li>
                                <li>エントリー費：{{ number_format($event->price) }}円</li>
                                <li>エントリー人数：{{ count($event->users) }}人</li>
                            </ul>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@stop

@section('css')
@stop

