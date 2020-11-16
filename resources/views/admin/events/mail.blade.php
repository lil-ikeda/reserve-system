@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <div class="container">
        <div class="col-md-7 offset-md-2 col-sm-12">
            <h3>一斉メール作成</h3>
            <div class="card">
                <form action="{{ route('admin.events.send.mail', $event->id) }}" method="POST">
                    <p class="card-header">{{ $event->name }}</p>
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        <p>件名</p>
                        <input type="text" name="subject"
                               class="col-12 form-control @error('subject') is-invalid @enderror"
                               value="{{ old('subject', $event->name . 'の開催が近づいてまいりました！') }}"
                        >
                        @error('subject')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </div>
                        @enderror
                        <p>テキスト作成</p>
                        <textarea name="text" cols="30" rows="10" class="form-control @error('text') is-invalid @enderror">{{ old('text', $text) }}</textarea>
                        @error('text')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('text') }}</strong>
                        </div>
                        @enderror
                        <hr>
                        <p>送信者一覧（合計：{{ count($entriedUsers) }}人）</p>
                        <div class="row">
                        @foreach($entriedUsers as $user)
                            <span class="col-6">
                                {{ $user->name }}
                            </span>
                            <input type="hidden" name="user_mails[]" value="{{ $user->email }}">
                            <input type="hidden" name="user_names[]" value="{{ $user->name }}">
                        @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">送信</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

