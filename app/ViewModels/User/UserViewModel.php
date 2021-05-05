<?php
declare(strict_types=1);

namespace App\ViewModels\User;

use App\Models\User;
use App\ViewModels\User\Base\ViewModel;

class UserViewModel extends ViewModel
{
    /**
     * ユーザー
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function collect($users)
    {
        return $users
            ->map(fn(User $user) => new self($user));
    }

    public function toMap(): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => $this->user->password,
            'phone' => $this->user->phone,
            'birthday' => $this->user->birthday,
            'sex' => $this->user->sex,
            'avatar' => $this->user->avatar,
            'circle_id' => $this->user->circle_id,
        ];
    }
}