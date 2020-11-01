@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    {{-- イベント情報 --}}

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-7 offset-2">
        <h3>イベント詳細</h3>
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
                        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" name="form" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="exampleInputFile">イメージ画像</label>
                                    <div class="input-group">
                                        <input type="file" class="" id="exampleInputFile" name="image"
{{--                                               value="{{ old('image', $event->image) }}"--}}
                                               onchange="setImage(event)">
                                    </div>
                                </div>
                                <div class="preview"></div>
                                <div class="form-group">
                                    <label for="name">イベント名</label>
                                    <input type="text" name="name" class="form-control"
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
                                              class="form-control">{{ $event->description }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date">日程</label>
                                    <input type="date" name="date" class="form-control"
                                           value="{{ old('date', $event->date) }}">
                                    @error('date')
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="place">場所</label>
                                    <input type="text" name="place" class="form-control"
                                           value="{{ old('place', $event->place) }}">
                                    @error('place')
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('place') }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">料金</label>
                                    <input type="number" name="price" class="form-control"
                                           value="{{ old('price', $event->price) }}">
                                    @error('price')
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="open_time">開始時間</label>
                                    <input type="time" name="open_time" class="form-control"
                                           value="{{ old('open_time', $event->open_time) }}">
                                    @error('open_time')
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('open_time') }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="close_time">終了時間</label>
                                    <input type="time" name="close_time" class="form-control"
                                           value="{{ old('close_time', $event->close_time) }}">
                                    @error('close_time')
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('close_time') }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">更新</button>
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
                    <p>エントリー数：　{{ count($users) }}人</p>
{{--                    <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                        <i class="fas fa-minus"></i>--}}
{{--                    </button>--}}
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
                            <th>支払ステータス</th>
                            <th>キャンセル</th>
                            <th>支払方法</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>アイコン</td>
                                <td><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></td>
                                @if ($shippingStatus[$user->id] == config('const.shipping_status.unpaid.id'))
                                    <td><span class="badge badge-danger">未払い</span></td>
                                @elseif ($shippingStatus[$user->id] == config('const.shipping_status.paid.id'))
                                    <td><span class="badge badge-success">支払済</span></td>
                                @endif
                                @if ($cancellationRequests[$user->id] == true)
                                    <td>
                                        <form action="{{ route('admin.entry.destroy', $event->id) }}" class="font-weight-bold" method="POST">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" value="{{ $user->id }}" name="userId">
                                            <input type="hidden" value="{{ $event->id }}" name="eventId">
                                            <button type="submit" onClick="return cancelConfirm()" class="">キャンセル待ち</button>
                                        </form>
                                    </td>
                                @elseif ($cancellationRequests[$user->id] == false)
                                    <td>-</td>
                                @endif
                                <td>{{ $paymentMethods[$user->id] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
{{--                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>--}}
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">エントリーユーザーに一斉メール</a>
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
    <link rel="stylesheet" href="/css/admin_custom.css">
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
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
