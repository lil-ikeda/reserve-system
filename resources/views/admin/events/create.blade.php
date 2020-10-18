@extends('adminlte::page')

@section('title', 'イベント作成')

@section('content_header')
    {{-- <h1>イベント作成</h1> --}}
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">イベント作成</h3>
        </div>
        <form action="{{ route('admin.events.store')}}" method="POST" enctype='multipart/form-data'>
            <div class="card-body">
{{--                @method('PUT')--}}
                @csrf
                <div class="form-group">
                  <label for="exampleInputFile">イメージ画像</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text" id="">Upload</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                    <label for="name">イベント名</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">イベント詳細</label>
                    {{-- <input type="text" name="description" class="form-control"> --}}
                    <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="date">日程</label>
                    <input type="date" name="date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="place">場所</label>
                    <input type="text" name="place" class="form-control">
                </div>
                <div class="form-group">
                    <label for="price">料金</label>
                    <input type="number" name="price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="open_time">開始時間</label>
                    <input type="time" name="open_time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="close_time">終了時間</label>
                    <input type="time" name="close_time" class="form-control">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">登録</button>
            </div>
        </form>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
