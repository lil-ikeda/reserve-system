@extends('adminlte::page')

@section('title', 'イベント作成')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="col-md-6 offset-2">
        <div class="card">
            <p class="card-header" style="background-color: rgba(0,0,0,.03);">イベント作成</p>
            <div class="card-body">
                <form action="{{ route('admin.events.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputFile">イメージ画像</label>
                      <div class="input-group">
                          <input type="file" class="" id="exampleInputFile" name="image" onchange="setImage(event)">
                      </div>
                    </div>
                    <div class="preview"></div>
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
                    <button type="submit" class="btn btn-info">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        function setImage(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            let preview = document.getElementsByClassName('preview')[0]
            let previewImage = document.getElementById('event-preview-image')

            // 既にプレビュー画像がある場合は一度リセット
            if (previewImage != null) {
                preview.removeChild(previewImage);
            } 

            reader.onload = function(e) {
                let img = document.createElement('img');
                img.setAttribute('src', reader.result);
                img.setAttribute('class', 'event-preview-image');
                img.setAttribute('style', 'width: 100%;');
                preview.setAttribute('style', 'margin-bottom: 40px;');
                preview.appendChild(img);
            }

            reader.readAsDataURL(file);

        }
    </script>
@stop
