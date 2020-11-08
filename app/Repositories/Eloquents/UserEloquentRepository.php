<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Contracts\Repositories\UserRepositoryContract;
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
     * すべてのユーザーを取得
     *
     * @return Collection
     */
    public function getAll(): Arrayable
    {
        $users = $this->user->all();

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
