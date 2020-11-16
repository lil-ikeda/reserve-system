<?php

namespace App\Repositories\Eloquents;

use App\Models\Admin;
use App\Contracts\Repositories\AdminRepositoryContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class AdminEloquentRepository implements AdminRepositoryContract
{
    /**
     * 管理者モデル
     *
     * @var Admin
     */
    private $admin;

    /**
     * construct
     *
     * EventEloquentRepository constructor.
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * すべての管理者を取得
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->admin->all();
    }

    /**
     * IDから管理者を取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable
    {
        return $this->admin->find($id);
    }

    /**
     * 管理ユーザーを削除
     *
     * @param ind $id
     */
    public function destroy(int $id):void
    {
        $this->findById($id)->delete();
    }
}
