<?php

namespace App\Repositories\Eloquents;

use App\Models\Circle;
use App\Contracts\Repositories\CircleRepositoryContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class CircleEloquentRepository implements CircleRepositoryContract
{
    /**
     * 管理者モデル
     *
     * @var Circle
     */
    private $cicle;

    /**
     * construct
     *
     * EventEloquentRepository constructor.
     * @param Admin $admin
     */
    public function __construct(Circle $circle)
    {
        $this->circle = $circle;
    }

    /**
     * すべての管理者を取得
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->circle->all();
    }
}
