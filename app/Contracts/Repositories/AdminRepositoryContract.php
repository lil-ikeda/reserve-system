<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface AdminRepositoryContract
{
    /**
     * IDから管理者を取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable;

    /**
     * 管理ユーザーを削除
     *
     * @param int $id
     */
    public function destroy(int $id):void;
}
