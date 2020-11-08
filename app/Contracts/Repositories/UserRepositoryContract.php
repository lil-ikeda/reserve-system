<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Ramsey\Collection\Collection;

interface UserRepositoryContract
{

    /**
     * すべてのユーザーを取得
     *
     * @return Collection
     */
    public function getAll(): Arrayable;

    /**
     * IDからユーザーを取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable;
}
