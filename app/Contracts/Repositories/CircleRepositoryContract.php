<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface CircleRepositoryContract
{
    /**
     * すべてのサークルを取得
     *
     * @return Collection
     */
    public function getAll(): Collection;
}
