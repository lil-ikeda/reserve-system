<?php

namespace App\Repositories\Eloquents\Admin;

use App\Models\Event;
use App\Models\Entry;
use App\Contracts\Repositories\Admin\EntryRepositoryContract;
use Illuminate\Support\Collection;

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
}
