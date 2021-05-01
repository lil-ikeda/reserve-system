@extends('user.layouts')
@section('title')イベント一覧@endsection
@section('content')
<div id='app'>
    <div class="main-container">
        <event-index
            :prop-events='@json($events)'
            s3-path={{ config('const.s3') }}
        ></event-index>
        
        {{-- ページネーション --}}
        <div class="d-flex justify-content-center">
        {{ $pagination->links('pagination::default') }}
        </div>
    </div>
</div>


@endsection