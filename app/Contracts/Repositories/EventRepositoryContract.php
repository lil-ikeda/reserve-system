<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Event;

interface EventRepositoryContract
{
    /**
     * 全てのイベントを取得
     *
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator;

    /**
     * ユーザー画面用にイベントを全て取得
     *
     * @return LengthAwarePaginator
     */
    public function getAllForUser(): LengthAwarePaginator;

    /**
     * IDからイベントを取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable;

    /**
     * IDからユーザー情報とともに特定のイベントを取得
     *
     * @param integer $id
     * @return Collection|null
     */
    public function findWithUsers(int $id): ?Event;

    /**
     * IDから特定のイベントと紐づくユーザー情報を取得
     *
     * @param integer $id
     * @return Arrayable
     */
    public function findWithUserCounts(int $id): Arrayable;

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
        object $image = null
    ): void;

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
        object $image = null
    ): void;

    public function getEntriedUsers(int $id): Collection;

    /**
     * 支払ステータスを取得
     *
     * @param object $entries
     * @return array
     */
    public function getShippingStatus(object $entries): array;

    /**
     * キャンセル希望有無を取得
     *
     * @param $entries
     * @return array
     */
    public function getCancellationRequest(object $entries): array;

    /**
     * 支払方法を取得
     *
     * @param object $entries
     * @return array
     */
    public function getPaymentMethod(object $entries): array;

    /**
     * イベントを削除
     */
    public function destroy(int $id): bool;

    /**
     * PayPay決済用のURLを取得
     *
     * @param string $eventName
     * @param int $eventPrice
     * @param int $eventId
     * @throws \PayPay\OpenPaymentAPI\ClientException
     * @throws \PayPay\OpenPaymentAPI\Controller\ClientControllerException
     * @throws \PayPay\OpenPaymentAPI\Models\ModelException
     */
    public function getPayPayUrl(string $eventName, int $eventPrice, int $eventId): string;
}
