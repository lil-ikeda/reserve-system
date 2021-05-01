@extends('user.layouts')
@section('title')イベントキャンセル@endsection
@section('content')
<div id='app'>
    <event-cancel
        entpoint-to-cancel-send-mail='{{ route('api.events.cancel.sendmail', $event['id']) }}'
        :cancel-requested='@json($cancelRequested)'
        route-to-top='{{ route('user.events.index') }}'
    ></event-cancel>
</div>
@endsection