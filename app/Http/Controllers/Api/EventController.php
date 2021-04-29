<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntryEvent;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Contracts\Repositories\EntryRepositoryContract;
use Illuminate\Support\Facades\Mail;
use App\Mail\EntryConfirm;


class EventController extends Controller
{
    /**
     * イベントリポジトリ
     *
     * @var EventRepositoryContract
     */
    private $eventRepository;

    /**
     * エントリーリポジトリ
     *
     * @var EntryRepositoryContract
     */
    private $entryRepository;

    public function __construct(
        EventRepositoryContract $eventRepository,
        EntryRepositoryContract $entryRepository
    )
    {
        $this->eventRepository = $eventRepository;
        $this->entryRepository = $entryRepository;
    }

    public function entry(int $id, EntryEvent $request)
    {
        $event = $this->eventRepository->findWithUsers($id);
        $user = Auth::user();

        if (!$event) {
            abort(404);
        }

        // 無料イベントなら「支払なし」とする
        $paymentMethod = ($request->input('free_event'))
            ? config('const.payment_method.free.id')
            : $request->input('payment_method');

        // エントリーレコード作成
        $this->entryRepository->sync($event->id, $user->id, $paymentMethod);

        // エントリー内容確認メール送信
        Mail::to($user)
            ->send(new EntryConfirm(
                $user->name,
                $event->name,
                $event->date,
                $event->open_time,
                $event->close_time,
                $event->price,
                $paymentMethod
            ));

        return response()->json('OK', 200);
    }
}
