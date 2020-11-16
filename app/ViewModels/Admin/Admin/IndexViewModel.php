<?php

namespace App\ViewModels\Admin\Admin;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\AdminRepositoryContract;

class IndexViewModel extends ViewModel
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
        return [
            'admins' => $this->adminRepository->getAll(),
        ];
    }
}
