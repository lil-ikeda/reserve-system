<?php

namespace App\Repositories\Eloquents\Admin;

use App\Models\Event;
use App\Models\Entry;
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

        $path = Storage::disk('s3')->putfile('/', $image, 'public');
        $url = Storage::disk('s3')->url($path);
        $event->image = '/' . basename(parse_url($url, PHP_URL_PATH));

        $event->save();
    }

    /**
     * エントリー済みのユーザーを取得
     *
     * @param int $id
     * @return Collection
     */
    public function getEntriedUsers(int $id): Collection
    {
        return $this->findById($id)->users;
    }

    /**
     * 支払ステータスを取得
     *
     * @param object $entries
     * @return array
     */
    public function getShippingStatus(object $entries): array
    {
        $shippingStatus = [];
        foreach ($entries as $entry) {
            $shippingStatus[$entry->user_id] = $entry->paid;
        }

        return $shippingStatus;
    }

    /**
     * キャンセル希望有無を取得
     *
     * @param $entries
     * @return array
     */
    public function getCancellationRequest(object $entries): array
    {
        $cancellationRequests = [];
        foreach ($entries as $entry) {
            switch ($entry->cancellation_request) {
                case false:
                    $cancellationRequests[$entry->user_id] = '-';
                    break;
                case true:
                    $cancellationRequests[$entry->user_id] = 'キャンセル待ち';
                    break;
            }
        }

        return $cancellationRequests;
    }

    /**
     * 支払方法を取得
     *
     * @param object $entries
     * @return array
     */
    public function getPaymentMethod(object $entries): array
    {
        $paymentMethods = [];
        foreach ($entries as $entry) {
            switch ($entry->payment_method) {
                case config('const.payment_method.paypay.id'):
                    $paymentMethods[$entry->user_id] = 'PayPay';
                    break;
                case config('const.payment_method.bank.id'):
                    $paymentMethods[$entry->user_id] = '口座振込';
                    break;
            }
        }

        return $paymentMethods;
    }

    /**
     * イベントを削除
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->event->destroy($id);
    }
}
