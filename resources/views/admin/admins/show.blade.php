@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>マイページ</h1>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $admin->name }}
            </div>
            <div class="card-body">
                <div class="">
                    <strong>メールアドレス：　</strong>{{ $admin->email }}
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}" onClick="return deleteConfirm()" style="display: inline;">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-outline-danger" >
                アカウントを削除する
            </button>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script type="text/javascript">
        function deleteConfirm() {
            let checked = confirm('本当に削除しますか？')
            if (checked == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@stop
