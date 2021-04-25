@extends('user.layouts')
@section('title')イベント詳細@endsection
@section('content')
<div id='app'>
    <event-show
      :prop-event='@json($event)'
      prop-href-to-top='{{ route('user.events.index') }}'
    ></event-show>
</div>
@endsection