<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct()
    {
        // exceptの引数以外は認証が必要
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
     */
    public function show(int $id)
    {
        $event = Event::where('id', $id)->with(['users'])->first();

        return $event ?? abort(404);
    }

    // イベントにエントリー
    public function join(string $id)
    {
        $event = Event::where('id', $id)->with('users')->first();

        if (! $event) {
            abort(404);
        }

        $event->users()->detach(Auth::user()->id);
        $event->users()->attach(Auth::user()->id);

        // $eventUser = new EventUser();
        // $eventUser->event_id = $id;
        // $eventUser->user_id = Auth::user()->id;
        // $eventUser->save();

        return ['event_id' => $id];
    }

    public function unjoin(string $id)
    {
        $event = Event::where('id', $id)->with('users')->first();

        if (! $event) {
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
