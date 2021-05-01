<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntryEvent;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Contracts\Repositories\EntryRepositoryContract;
use Illuminate\Support\Facades\Mail;
use App\Mail\EntryConfirm;
use App\Mail\CancelRequest;


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

    /**
     * イベントのエントリー処理
     *
     * @param integer $id
     * @param EntryEvent $request
     * @return void
     */
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

    /**
     * キャンセル希望メールの送信
     *
     * @param int $id
     */
    public function cancelSendMail(int $id)
    {
        $user = Auth::user();
        $event = $this->eventRepository->findById($id);

        // 「エントリー」レコードのキャンセルリクエストをtrueにする
        $entry = $this->entryRepository->cancelRequest($event->id, $user->id);

        if ($entry) {
            Mail::to(config('const.skillhack_mail'))
                ->send(new CancelRequest($user->name, $event->id, $event->name, $entry->paid));
            return response()->json('OK', 200);
        }
    }

    /**
     * イベントエントリーのキャンセル希望をリクエスト
     *
     * @param string $id
     * @return void
     */
    public function cancel(int $id)
    {
        $event = $this->eventRepository->findWithUsers($id);

        if (!$event) {
            abort(404);
        }

        $this->entryRepository->sync($id, Auth::id(), NULL);

        return response()->json(['event_id' => $id], 200);
    }

    /**
     * PayPay支払いページのURLを生成
     *
     * @param integer $id
     * @return void
     */
    public function pay(int $id)
    {
        $event = $this->eventRepository->findById($id);

        // PayPayQRコード生成と決済ページのURL生成
        $redirectUrl = $this->eventRepository->getPayPayUrl($event->name, $event->price, $event->id);

        return $redirectUrl;
    }
}
