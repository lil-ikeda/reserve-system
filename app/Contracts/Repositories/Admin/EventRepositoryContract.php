<?php

namespace App\Contracts\Repositories\Admin;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface EventRepositoryContract
{
    /**
     * 全てのイベントを取得
     *
     * @return array
     */
    public function getAll(): Collection;

    /**
     * IDからイベントを取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable;

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
        object $image
    ): void;

    public function getEntriedUsers(int $id): Collection;

    /**
     * イベントを削除
     */
    public function destroy(int $id): bool;
}
