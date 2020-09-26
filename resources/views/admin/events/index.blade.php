@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>イベント一覧</h1>
@stop

@section('content')
<!-- Style -->
<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <div class="container">
        @foreach ($events as $event)
        <a href="{{ route('admin.events.show', $event->id) }}" class="text-decoration-none">
          <div class="card card-primary card-outline">
            {{-- <div class="event-card__left">
                <div class="event-card__left--img">
                    <img :src="`/storage/${event.image}`">
                </div>
            </div> --}}
            {{-- <div class="event-card__right"> --}}
                <p class="card-header">{{ $event->name }}</p>
                <div class="card-body">
                    <ul>
                        <li>日程：{{ $event->date }}</li>
                        <li>時間：{{ $event->open_time }} - {{ $event->close_time }}</li>
                        <li>場所：{{ $event->place }}</li>
                    </ul>
                </div>
            {{-- </div> --}}
        </div>
        </a>
        @endforeach
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

