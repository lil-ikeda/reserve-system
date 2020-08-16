<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        // $events = Event::all()->orderBy(Event::CREATED_AT, 'desc')->paginate();
        // dd('OK');
        $events = DB::table('events')->orderBy('created_at', 'desc')->get();
        return $events;
    }

    public function show(string $id)
    {
        $event = Event::find($id);
        return $event ?? abort(404);
    }

    public function store(Request $request)
    {
        // 写真の拡張子を取得
        // $extension = $request->image->extension();

        $event = new Event();
        $event->name  = $request->name;
        $event->description  = $request->description;
        $event->date  = $request->date;
        $event->open_time  = $request->open_time;
        $event->close_time  = $request->close_time;
        $event->place  = $request->place;
        $event->price  = $request->price;
        $event->image = $request->file('image')->store('events');
        
        // $event->image = $request->image;
        // dd($event->image);
        // $directory = '/storage/app/public/eventImage';
        // Storage::disk('local')->put($request->image, $event->image);
        // dd(Storage::url($event->image));
        DB::beginTransaction();
        
        try {
            $event->save();
            DB::commit();
        } catch(\Exception $exception) {
            DB::rollback();
            Storage::disk('local')->delete($event->image);
            throw $exception;
        }
        return response($event, 201);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());
        return $event;
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return $event;
    }
}
