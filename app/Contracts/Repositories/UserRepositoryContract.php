<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Ramsey\Collection\Collection;
use App\Repositories\Params\UserParams;

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

    /**
     * ユーザーのプロフィールを更新
     *
     * @param integer $userId
     * @param UserParams $userParams
     * @return void
     */
    public function update(int $userId, UserParams $userParams): void;
}
