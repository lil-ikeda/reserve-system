<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\EntryEvent;
use App\Mail\CancelCompletRequest;
use App\Mail\EntryConfirm;
use App\Models\Event;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\CancelRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests\SendEntryConfirmMail;
use App\Http\Requests\SendCancelRequestMail;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Contracts\Repositories\EntryRepositoryContract;
use App\ViewModels\User\EventViewModel;

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
     * @var
     */
    private $entryRepository;

    public function __construct(EventRepositoryContract $eventRepository, EntryRepositoryContract $entryRepository)
    {
        $this->middleware('verified')->except(['index', 'show']);
        $this->eventRepository = $eventRepository;
        $this->entryRepository = $entryRepository;
    }

    /**
     * イベント一覧（開催前のイベントのみ取得）
     */
    public function index()
    {
        $events = $this->eventRepository->getAllForUser();

        return view('user.events.index')->with([
            'events' => EventViewModel::collect($events)->toArray(),
            'pagination' => $events
        ]);
    }

    /**
     * イベント詳細
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $event = $this->eventRepository->findWithUserCounts($id);

        return view('user.events.show')->with([
            'event' => (new EventViewModel($event))->toArray()
        ]);
    }

    /**
     * キャンセル希望メールの送信
     *
     * @param int $id
     */
    public function cancelSendMail(SendCancelRequestMail $request)
    {
        $user = Auth::user();
        $event = $this->eventRepository->findById($request->input('id'));

        // 「エントリー」レコードのキャンセルリクエストをtrueにする
        $entry = Entry::where('event_id', $event->id)
            ->where('user_id', $user->id)->first();

        Mail::to(config('const.skillhack_mail'))
            ->send(new CancelRequest($user->name, $event->id, $event->name, $entry->paid));

        $entry->cancellation_request = true;
        $entry->save();

        return 200;
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
        $user = Auth::user();

        if (!$event) {
            abort(404);
        }

        // 既存の「エントリー」レコードを削除
        $event->users()->detach($user->id);

        // 「支払方法」がnullなら「支払なし」とする
        $paymentMethod = (is_null($request->input('paymentMethod')))
            ? $request->input('paymentMethod')
            : config('const.payment_method.free.id');

        $entry = DB::table('entries')->insert([
            'event_id' => $id,
            'user_id' => $user->id,
            'paid' => false,
            'cancellation_request' => false,
            'payment_method' => $paymentMethod,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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

    public function pay(int $id)
    {
        $event = $this->eventRepository->findById($id);

        // PayPayQRコード生成と決済ページのURL生成
        $redirectUrl = $this->eventRepository->pay($event->name, $event->price, $event->id);

        return $redirectUrl;
    }

    public function paid(int $id)
    {
        $response = $this->entryRepository->pay($id);

        if ($response === true) {
            return redirect('/');
        }
    }
}
