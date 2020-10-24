<?php

namespace App\Repositories\Eloquents\Admin;

use App\Models\Event;
use App\Contracts\Repositories\Admin\EventRepositoryContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class EventEloquentRepository implements EventRepositoryContract
{
    /**
     * イベントモデル
     *
     * @var Event
     */
    private $event;

    /**
     * construct
     *
     * EventEloquentRepository constructor.
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * 全てのイベントを取得
     *
     * @return array
     */
    public function getAll(): Collection
    {
        $events = $this->event->all();
        return $events;
    }

    /**
     * IDからイベントを取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable
    {
        return $this->event->find($id);
    }

    /**
     * イベントの保存
     *
     * @param string $name
     * @param string $description
     * @param string $date
     * @param string $openTime
     * @param string $closeTime
     * @param string $place
     * @param int $price
     * @param object $image
     */
    public function store(
        string $name,
        string $description,
        string $date,
        string $openTime,
        string $closeTime,
        string $place,
        int $price,
        object $image
    ): void {
        $this->event->name = $name;
        $this->event->description = $description;
        $this->event->date = $date;
        $this->event->open_time = $openTime;
        $this->event->close_time = $closeTime;
        $this->event->place = $place;
        $this->event->price = $price;
        
        // $image->store('events', 'public');
        // $path = $image->store('public/events');
        $path = Storage::disk('s3')->putfile('/', $image, 'public');
        $url = Storage::disk('s3')->url($path);

        $this->event->image = '/' . basename(parse_url($url, PHP_URL_PATH));

        $this->event->save();
    }

    /**
     * イベントの更新
     *
     * @param string $name
     * @param string $description
     * @param string $date
     * @param string $openTime
     * @param string $closeTime
     * @param string $place
     * @param int $price
     * @param object $image
     */
    public function update(
        int $id,
        string $name,
        string $description,
        string $date,
        string $openTime,
        string $closeTime,
        string $place,
        int $price,
        object $image
    ): void {
        $event = $this->findById($id);

        $event->name = $name;
        $event->description = $description;
        $event->date = $date;
        $event->open_time = $openTime;
        $event->close_time = $closeTime;
        $event->place = $place;
        $event->price = $price;
        $this->event->save();
        
        $image->store('events', 'public');
    }

    public function getEntriedUsers(int $id): Collection
    {
        return $this->findById($id)->users;
    }

    public function destroy(int $id): bool
    {
        return $this->event->destroy($id);
    }
}
