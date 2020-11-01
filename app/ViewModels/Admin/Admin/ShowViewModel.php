<?php

namespace App\ViewModels\Admin\Admin;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\Admin\AdminRepositoryContract;

class ShowViewModel extends ViewModel
{
    /**
     * 管理者リポジトリ
     *
     * @var
     */
    private $adminRepository;

    /**
     * 管理者ID
     *
     * @var
     */
    private $id;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function toMap(): array
    {
        $id = $this->getId() ?? 0;

        return [
            'admin' => $this->adminRepository->findById($id),
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
