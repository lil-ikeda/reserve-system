<?php

namespace App\ViewModels\Admin\User;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\UserRepositoryContract;

class ShowViewModel extends ViewModel
{
    /**
     * 管理者リポジトリ
     *
     * @var
     */
    private $userRepository;

    /**
     * 管理者ID
     *
     * @var
     */
    private $id;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function toMap(): array
    {
        $id = $this->getId() ?? 0;

        return [
            'user' => $this->userRepository->findById($id),
        ];
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
