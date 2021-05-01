<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Ramsey\Collection\Collection;

interface UserRepositoryContract
{

    /**
     * 全ユーザーをペジネーションで取得
     *
     * @return Paginator
     */
    public function getAll(): Paginator;

    /**
     * IDからユーザーを取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable;
}
