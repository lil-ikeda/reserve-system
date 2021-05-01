<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use App\Models\Entry;

interface EntryRepositoryContract
{
    /**
     * イベントIDからエントリーを取得
     *
     * @param int $id
     * @return Collection
     */
    public function getByEventId(int $id): Collection;

    /**
     * エントリーの削除（キャンセル受諾）
     *
     * @param int $eventId
     * @param int $userId
     * @return bool
     */
    public function destroy(int $eventId, int $userId): bool;

    /**
     * イベントIDとユーザーIDからエントリーレコードを取得
     *
     * @param int $eventId
     * @param int $userId
     * @return Collection
     */
    public function getByEventAndUserId(int $eventId, int $userId): ?Entry;

    /**
     * キャンセルリクエストの送信
     *
     * @param integer $eventId
     * @param integer $userId
     * @return Entry
     */
    public function cancelRequest(int $eventId, int $userId): Entry;
    
    /**
     * 1エントリーレコードに対し支払済にする
     *
     * @param int $id
     * @return bool
     */
    public function pay(int $id): bool;

    /**
     * 特定のエントリーレコードを支払済にする（口座振替の場合）
     *
     * @param integer $userId
     * @param integer $eventId
     * @return boolean
     */
    public function paid(int $userId, int $eventId): bool;

    /**
     * エントリーステータスを更新（イベントID・ユーザーIDの組み合わせが既にあれば消す、なければ登録する）
     *
     * @param integer $eventId
     * @param integer $userId
     * @param integer $paymentMethod
     * @return void
     */
    public function sync(int $eventId, int $userId, ?int $paymentMethod): void;
}
