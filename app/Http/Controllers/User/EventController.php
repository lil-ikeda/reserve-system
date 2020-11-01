<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\EntryEvent;
use App\Mail\CancelCompleted;
use App\Mail\EntryConfirm;
use App\Models\Event;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\Canceled;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests\SendEntryConfirmMail;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * イベント一覧
     */
    public function index()
    {
        $events = DB::table('events')->orderBy('created_at', 'desc')->get();

        return $events;
    }

    /**
     * イベント詳細
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $event = Event::where('id', $id)->with('users')->first();

        return $event ?? abort(404);
    }

//    /**
//     * イベントエントリー画面の表示
//     *
//     * @param int $id
//     */
//    public function entry(int $id)
//    {
//        $event = Event::find($id);
//
//        return $event ?? abort(404);
//    }
//
//    /**
//     * イベントエントリー完了画面の表示
//     *
//     * @param int $id
//     */
//    public function entryConfirm(int $id)
//    {
//        $event = Event::find($id);
//
//        return $event ?? abort(404);
//    }
//
//    /**
//     * キャンセル
//     *
//     * @param int $id
//     */
//    public function cancel(int $id)
//    {
//        $event = Event::find($id);
//
//        return $event ?? abort(404);
//    }
//
//    /**
//     * キャンセル確認用画面の表示
//     *
//     * @param int $id
//     */
//    public function cancelConfirm(int $id)
//    {
//        $event = Event::find($id);
//
//        return $event ?? abort(404);
//    }

    /**
     * キャンセル希望メールの送信
     *
     * @param int $id
     */
    public function cancelSendMail(SendCancelRequestMail $request)
    {
        Mail::to('n.ikeda@arsaga.jp')->send(new Canceled);

        // 「エントリー」レコードのキャンセルリクエストをtrueにする
        $entry = Entry::where('event_id', $request->input('id'))
            ->where('user_id', Auth::user()->id)->first();

        $entry->cancellation_request = true;
        $entry->save();

        return 200;
    }


    public function paymentPayPay(int $id)
    {
        $event = Event::find($id);

        return $event ?? abort(404);
    }

    /**
     * イベントにエントリー
     *
     * @param string $id
     * @return array
     */
    public function join(string $id, EntryEvent $request)
    {
        $event = Event::where('id', $id)->with('users')->first();

        if (!$event) {
            abort(404);
        }

        // 既存の「エントリー」レコードを削除
        $event->users()->detach(Auth::user()->id);

        $entry = DB::table('entries')->insert([
            'event_id' => $id,
            'user_id' => Auth::user()->id,
            'paid' => false,
            'cancellation_request' => false,
            'payment_method' => $request->input('paymentMethod'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // エントリー内容確認メール送信
        Mail::to(Auth::user())->send(new EntryConfirm);

        return response($entry, 200);
    }

    public function unjoin(string $id)
    {
        $event = Event::where('id', $id)->with('users')->first();

        if (!$event) {
            abort(404);
        }

        $event->users()->detach(Auth::user()->id);

        return ['event_id' => $id];
    }

    // /**
    //  * イベント保存
    //  */
    // public function store(Request $request)
    // {
    //     // 写真の拡張子を取得
    //     // $extension = $request->image->extension();
    //     $event = new Event();
    //     $event->name  = $request->name;
    //     $event->description  = $request->description;
    //     $event->date  = $request->date;
    //     $event->open_time  = $request->open_time;
    //     $event->close_time  = $request->close_time;
    //     $event->place  = $request->place;
    //     $event->price  = $request->price;
    //     if ($request->file('image') !== null) {
    //         $event->image = $request->file('image')->store('events');
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $event->save();
    //         DB::commit();
    //     } catch (\Exception $exception) {
    //         DB::rollback();
    //         Storage::disk('local')->delete($event->image);
    //         throw $exception;
    //     }
    //     return response($event, 201);
    // }

    // /**
    //  * イベント更新
    //  */
    // public function update(Request $request, Event $event)
    // {
    //     $event->update($request->all());
    //     return $event;
    // }

    // /**
    //  * イベント削除
    //  */
    // public function destroy(Event $event)
    // {
    //     $event->delete();
    //     return $event;
    // }
}
