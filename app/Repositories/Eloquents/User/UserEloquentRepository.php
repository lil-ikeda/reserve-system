<?php

namespace App\Repositories\Eloquents\User;

use App\Models\Event;
use App\Contracts\Repositories\User\UserRepositoryContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class UserEloquentRepository implements UserRepositoryContract
{
    /**
     * イベントモデル
     *
     * @var User
     */
    private $user;

    /**
     * construct
     *
     * EventEloquentRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function join()
    {
        
    }
}
