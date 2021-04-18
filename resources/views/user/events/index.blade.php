@extends('user.layouts')
@section('title')イベント一覧@endsection
@section('content')


<div id='app'>
  <div class="main-container">
    <event-index
      :prop-events='@json($events)'
    ></event-index>
    <div class="d-flex justify-content-center">
      {{ $pagination->links() }}
    </div>
  </div>
</div>


@endsection