<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

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
    public function getByEventAndUserId(int $eventId, int $userId): Arrayable;

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
}
