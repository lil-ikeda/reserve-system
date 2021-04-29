@extends('user.layouts')
@section('title')イベントエントリー@endsection
@section('content')
<div id='app'>
    <event-entry
        :prop-event='@json($event)'
        :free-event='@json($event['isFree'])'
        :entered='@json($entered)'
        route-to-top='{{ route('user.events.index') }}'
        route-to-back='{{ route('user.events.show', $event['id']) }}'
        route-to-entry='{{ route('api.events.entry', $event['id']) }}'
        payment-method-paypay={{ config('const.payment_method.paypay') }}
        payment-method-bank={{ config('const.payment_method.bank') }}
    ></event-entry>
</div>
@endsection