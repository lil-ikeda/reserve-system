@extends('user.layouts')
@section('title')マイページ@endsection
@section('content')
<div id="app">
    <div class="main-container">
        <my-page
            update-route='{{ route('user.users.update') }}'
            csrf-token="{{ csrf_token() }}"
            :prop-circles='@json($circles)'
            :prop-auth-user='@json($user)'
            :prop-errors='@json($errors->default)'
            :prop-old='@json(old())'
            s3-path='{{ config('const.s3') }}'
        >
        </my-page>
        @if ($errors->any())
        <div class=“errors”>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
</div>
@endsection
