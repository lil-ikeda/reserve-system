@extends('adminlte::page')

@section('title', 'イベント作成')

@section('content_header')

@stop

@section('content')
<div class="container">
    <div class="col-md-6 offset-md-2">
        <div class="card">
            <p class="card-header" style="background-color: rgba(0,0,0,.03);">イベント作成</p>
            <div class="card-body">
                <form action="{{ route('admin.events.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputFile">イメージ画像</label>
                      <div class="input-group">
                          <input type="file" class="form-control @error('image') is-invalid @enderror" id="exampleInputFile" name="image" onchange="setImage(event)">
                          @error('image')
                          <div class="invalid-feedback">
                              <strong>{{ $errors->first('image') }}</strong>
                          </div>
                          @enderror
                      </div>
                    </div>
                    <div class="preview"></div>
                    <div class="form-group">
                        <label for="name">イベント名 <span class="badge badge-danger">必須</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">イベント詳細 <span class="badge badge-danger">必須</span></label>
                        <textarea name="description" id="" cols="30" rows="10"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">日程 <span class="badge badge-danger">必須</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                        @error('date')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('date') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="place">場所 <span class="badge badge-danger">必須</span></label>
                        <input type="text" name="place" class="form-control @error('place') is-invalid @enderror" value="{{ old('place') }}">
                        @error('place')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('place') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">エントリー費 <span class="badge badge-danger">必須</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0">
                        @error('price')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('price') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="open_time">開始時間 <span class="badge badge-danger">必須</span></label>
                        <input type="time" name="open_time" class="form-control @error('open_time') is-invalid @enderror" value="{{ old('open_time') }}">
                        @error('open_time')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('open_time') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="close_time">終了時間 <span class="badge badge-danger">必須</span></label>
                        <input type="time" name="close_time" class="form-control @error('close_time') is-invalid @enderror" value="{{ old('close_time') }}">
                        @error('close_time')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('close_time') }}</strong>
                        </div>
                        @enderror
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
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
@stop

@section('js')
<script type="text/javascript">
    function setImage(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        let preview = document.getElementsByClassName('preview')[0]
        let previewImage = document.getElementsByClassName('event-preview-image')[0]
        // 既にプレビュー画像がある場合は一度リセット
        if (previewImage != null) {
            preview.removeChild(previewImage);
        }
        reader.onload = function (e) {
            let img = document.createElement('img');
            img.setAttribute('src', reader.result);
            img.setAttribute('class', 'event-preview-image');
            img.setAttribute('style', 'width: 100%;');
            preview.setAttribute('style', 'margin-bottom: 40px;');
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
    function deleteConfirm() {
        let checked = confirm('本当に削除しますか？')
        if (checked == true) {
            return true;
        } else {
            return false;
        }
    }
    function cancelConfirm() {
        let checked = confirm('本当に削除しますか？返金処理は完了していますか？')
        if (checked == true) {
            return true;
        } else {
            return false;
        }
    }
    function paidConfirm() {
        let checked = confirm('本当に「支払済」にしますか？支払いは完了していますか？')
        if (checked == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
@stop
