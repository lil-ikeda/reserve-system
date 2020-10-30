<?php

namespace App\Contracts\Repositories\Admin;

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
}
