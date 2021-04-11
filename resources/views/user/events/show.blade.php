@extends('user.layouts')
@section('title')イベント詳細@endsection
@section('content')
<div id='app'>
  <div class="event-container">
    <event-show
      :prop-event='@json($event)'
      prop-href-to-top='{{ route('users.events.index') }}'
    ></event-show>
  </div>
</div>
@endsection