<?php

namespace App\Repositories\Eloquents;

use App\Models\Event;
use App\Models\Entry;
use App\Contracts\Repositories\EntryRepositoryContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EntryEloquentRepository implements EntryRepositoryContract
{
    /**
     * イベントモデル
     *
     * @var Event
     */
    private $event;

    /**
     * エントリーモデル
     *
     * @var
     */
    private $entry;

    /**
     * construct
     *
     * EventEloquentRepository constructor.
     * @param Event $event
     */
    public function __construct(Event $event, Entry $entry)
    {
        $this->event = $event;
        $this->entry = $entry;
    }

    /**
     * イベントIDからエントリーを取得
     *
     * @param int $id
     * @return Collection
     */
    public function getByEventId(int $id): Collection
    {
        $entries = $this->entry->where('event_id', $id)->get();

        return $entries;
    }

    /**
     * エントリーの削除（キャンセル受諾）
     *
     * @param int $eventId
     * @param int $userId
     * @return bool
     */
    public function destroy(int $eventId, int $userId): bool
    {
        $entry = $this->entry
            ->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();

        return $entry->delete();
    }

    /**
     * イベントIDとユーザーIDからエントリーレコードを取得
     *
     * @param int $eventId
     * @param int $userId
     * @return Collection
     */
    public function getByEventAndUserId(int $eventId, int $userId): Arrayable
    {
        $entry = $this->entry->where('event_id', $eventId)->where('user_id', $userId)->first();

        return $entry;
    }

    /**
     * 1エントリーレコードに対し支払済にする
     *
     * @param int $id
     * @return bool
     */
    public function pay(int $id): bool
    {
        $entry = $this->getByEventAndUserId($id, Auth::id());

        // PayPay以外の支払いの場合処理を中断
        if ($entry->payment_method !== config('const.payment_method.paypay.id')) {
            return false;
        }

        // 支払済とする
        $entry->paid = true;

        return $entry->save();
    }
}
