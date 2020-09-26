@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>イベント詳細</h1>
@stop

@section('content')
<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
{{-- イベント情報 --}}
<div class="container">
  <div class="card">
    <div class="card-header d-flex p-0">
    <h3 class="card-title p-3">{{ $event->name }}</h3>
      <ul class="nav nav-pills ml-auto p-2">
        <li class="nav-item"><a class="nav-link" href="#tab_1" data-toggle="tab">編集</a></li>
        <li class="nav-item"><a class="nav-link active" href="#tab_2" data-toggle="tab">詳細</a></li>
      </ul>
    </div><!-- イベント編集 -->
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane" id="tab_1">
          <form action="{{ route('admin.events.update', $event->id) }}" method="PUT" role="form">
            <div class="card-body">
                @csrf
                <div class="form-group">
                  <label for="exampleInputFile">イメージ画像</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="exampleInputFile" value="{{ old('image', $event->image) }}">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text" id="">Upload</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                    <label for="name">イベント名</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}">
                </div>
                <div class="form-group">
                    <label for="description">イベント詳細</label>
                    {{-- <input type="text" name="description" class="form-control"> --}}
                    <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $event->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="date">日程</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $event->date) }}">
                </div>
                <div class="form-group">
                    <label for="place">場所</label>
                    <input type="text" name="place" class="form-control" value="{{ old('place', $event->place) }}">
                </div>
                <div class="form-group">
                    <label for="price">料金</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $event->price) }}">
                </div>
                <div class="form-group">
                    <label for="open_time">開始時間</label>
                    <input type="time" name="open_time" class="form-control" value="{{ old('open_time', $event->open_time) }}">
                </div>
                <div class="form-group">
                    <label for="close_time">終了時間</label>
                    <input type="time" name="close_time" class="form-control" value="{{ old('close_time', $event->close_time) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
        </form>
        </div>
        <!-- イベント詳細 -->
        <div class="tab-pane active" id="tab_2">
          <img src="{{ $event->image }}" alt="">
          <ul>
            <li>日程：{{ $event->date }}</li>
            <li>時間：{{ $event->open_time }} - {{ $event->close_time }}</li>
            <li>場所：{{ $event->place }}</li>
            <li>エントリー費：{{ $event->price }}</li>
            <li class="break-spaces">詳細：{{ $event->description }}</li>
          </ul>
        </div>
      </div>
      <!-- /.tab-content -->
    </div><!-- /.card-body -->
  </div>

    {{-- エントリーユーザー --}}
    <div class="card">
      <div class="card-header border-transparent">
        <h3 class="card-title">エントリーユーザー一覧</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
                <tr>
                  <th>アイコン</th>
                  <th>ユーザー名</th>
                  <th>ステータス</th>
                  {{-- <th>Popularity</th> --}}
                </tr>
            </thead>
            <tbody>
            <tr>
              <td>アイコン</td>
              <td><a href="pages/examples/invoice.html">田中ユウキ</a></td>
              <td><span class="badge badge-success">Shipped</span></td>
              {{-- <td>
                <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
              </td> --}}
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
      </div>
      <!-- /.card-footer -->
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
