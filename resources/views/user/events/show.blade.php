@extends('user.layouts')
@section('title')イベント詳細@endsection
@section('content')
<div id='app'>
    <event-show
        :prop-event='@json($event)'
        route-to-top='{{ route('user.events.index') }}'
        route-to-entry='{{ route('user.events.entry', $event['id']) }}'
        s3-path={{ config('const.s3') }}
    ></event-show>
</div>
@endsection