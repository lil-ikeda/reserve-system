<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\CancelRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests\SendEntryConfirmMail;
use App\Http\Requests\SendCancelRequestMail;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Contracts\Repositories\EntryRepositoryContract;
use App\ViewModels\User\EntryStatusViewModel;
use App\ViewModels\User\EventViewModel;
use App\ViewModels\User\EventShowViewModel;

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
            'event' => (new EventShowViewModel($event))->toArray(),
        ]);
    }

    /**
     * エントリーページを表示
     *
     * @param integer $id
     * @return void
     */
    public function entryPage(int $id)
    {
        $event = $this->eventRepository->findById($id);

        $entered = $event->entries->filter(function($entry) {
            return $entry->user_id === Auth::id();
        });

        return view('user.events.entry')->with([
            'event' => (new EventViewModel($event))->toArray(),
            'entered' => $entered->isNotEmpty()
        ]);
    }

    /**
     * エントリーキャンセルページを表示
     *
     * @param integer $id
     * @return void
     */
    public function cancelPage(int $id)
    {
        $event = $this->eventRepository->findById($id);

        $cancelRequested = $event->entries->filter(function($entry) {
            return $entry->user_id === Auth::id() && (bool)$entry->cancellation_request === true;
        });

        return view('user.events.cancel')->with([
            'event' => (new EventViewModel($event))->toArray(),
            'cancelRequested' => $cancelRequested->isNotEmpty()
        ]);
    }

    /**
     * PayPay決済後DBの支払いステータスを更新する
     *
     * @param integer $id
     * @return void
     */
    public function paid(int $id)
    {
        $response = $this->entryRepository->pay($id);

        if ($response) {
            // TODO: 決済完了確認のメールを送信する
            // Mail::to(Auth::user()->email)
            //     ->send()

            return redirect(route('user.events.show', $id))
                ->with('flash_message', trans('message.success.pay'));
        } else {
            abort(404);
        }
    }
}
