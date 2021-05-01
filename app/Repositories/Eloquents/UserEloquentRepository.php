<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Ramsey\Collection\Collection;

class UserEloquentRepository implements UserRepositoryContract
{
    /**
     * ユーザーモデル
     *
     * @var User
     */
    private $user;

    /**
     * UserEloquentRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 全ユーザーをペジネーションで取得
     *
     * @return Paginator
     */
    public function getAll(): Paginator
    {
        $users = $this->user->with('circle')->paginate(15);

        return $users;
    }

    /**
     * IDからユーザーを取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable
    {
        $user = $this->user->find($id);

        return $user;
    }
}
