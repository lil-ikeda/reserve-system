@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    {{-- イベント情報 --}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <div class="col-md-7 offset-md-2 col-sm-12 pb-3">
        <h3>イベント編集</h3>
        <div class="card">
            <div class="card-header p-0">
                <h3 class="card-title p-3">{{ $event->name }}</h3>
            </div>
            <!-- イベント編集 -->
            <div class="card-body">
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" name="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputFile">イメージ画像</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="exampleInputFile" name="image"
{{--                                               value="{{ old('image', $event->image) }}"--}}
                                    onchange="setImage(event)">
                            @error('image')
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('image') }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="preview"></div>
                    <div class="form-group">
                        <label for="name">イベント名</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $event->name) }}">
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">イベント詳細</label>
                        <textarea name="description" id="" cols="30" rows="10"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">日程</label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date', $event->date) }}">
                        @error('date')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('date') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="place">場所</label>
                        <input type="text" name="place" class="form-control @error('place') is-invalid @enderror"
                                value="{{ old('place', $event->place) }}">
                        @error('place')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('place') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">料金</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $event->price) }}">
                        @error('price')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('price') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="open_time">開始時間</label>
                        <input type="time" name="open_time" class="form-control @error('open_time') is-invalid @enderror"
                                value="{{ old('open_time', $event->open_time) }}">
                        @error('open_time')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('open_time') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="close_time">終了時間</label>
                        <input type="time" name="close_time" class="form-control @error('close_time') is-invalid @enderror"
                                value="{{ old('close_time', $event->close_time) }}">
                        @error('close_time')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('close_time') }}</strong>
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info">更新</button>
                </form>
            </div>
        </div>

        {{-- エントリーユーザー --}}
        <div class="card">
            <!-- card-header -->
            <div class="card-header border-transparent">
                <h3 class="card-title">エントリーユーザー一覧</h3>

                <div class="card-tools">
                    <p>エントリー数：　{{ count($users) }}人</p>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @foreach ($users as $user)
                    <div class="d-flex border-bottom mb-3">
                        <div class="mr-3">
                            <img src="{{ asset($avators[$user->id]) }}" style="width: 50px; height: 50px;">
                        </div>
                        <ul class="list-group-flush">
                            <li class="list-group-item p-1 text-break">{{ $user->name }}</li>
                            <li class="list-group-item p-1 text-break">
                                {{ $paymentMethods[$user->id] }}
                            </li>
                            <li class="list-group-item p-1 text-break">
                                @if ($shippingStatus[$user->id] == config('const.shipping_status.unpaid.id'))
                                <form action="{{ route('admin.entry.paid', $event->id) }}" method="POST">
                                    @csrf
                                    @method('post')
                                    <input type="hidden" value="{{ $user->id }}" name="userId">
                                    <input type="hidden" value="{{ $event->id }}" name="eventId">
                                    <button type="submit" onClick="return paidConfirm()" class="p-2 badge badge-danger">未払い</span>
                                </form>
                                
                                @elseif($shippingStatus[$user->id] == config('const.shipping_status.paid.id'))
                                <span class="badge badge-success p-2">支払済</span>
                                @endif
                            </li>
                            <li class="list-group-item p-1 text-break">
                                @if ($cancellationRequests[$user->id] == true)
                                    <form action="{{ route('admin.entry.destroy', $event->id) }}" class="font-weight-bold" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" value="{{ $user->id }}" name="userId">
                                        <input type="hidden" value="{{ $event->id }}" name="eventId">
                                        <button type="submit" onClick="return cancelConfirm()" class="badge-warning">キャンセル待ち</button>
                                    </form>
                                @elseif ($cancellationRequests[$user->id] == false)
                                -
                                @endif
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{ route('admin.events.send.mail', $event->id) }}" class="btn btn-sm btn-secondary float-right">エントリーユーザーに一斉メール</a>
            </div>
            <!-- /.card-footer -->
        </div>

        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-outline-danger" onclick="return deleteConfirm()">イベントを削除</button>
        </form>
    </div>

@stop

@section('css')
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

@section('css')
@stop
