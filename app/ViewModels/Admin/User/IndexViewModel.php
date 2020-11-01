<?php

namespace App\ViewModels\Admin\User;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\Admin\UserRepositoryContract;

class IndexViewModel extends ViewModel
{
    /**
     * イベントリポジトリ
     *
     * @var
     */
    private $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 性別を「男女」表記で取得
     *
     * @param collection $users
     * @return array
     */
    private function getSex($users)
    {
        $sexes = [];
        foreach ($users as $user) {
            switch ($user->sex) {
                case config('const.sex.male.id'):
                    $sexes[$user->id] = '男性';
                    break;
                case config('const.sex.female.id'):
                    $sexes[$user->id] = '女性';
                    break;
                case config('const.sex.do_not_answer.id'):
                    $sexes[$user->id] = '回答しない';
                    break;
            }
        }
        return $sexes;
    }

    private function getAvators($users)
    {
        $avators = [];
        foreach ($users as $user) {
            if (is_null($user->avator)) {
                $avators[$user->id] = 'img/noavator.png';
            } else {
                $avators[$user->id] = 'img/noavator.png';
            }
        }
        return $avators;
    }

    public function toMap(): array
    {
        $users = $this->userRepository->getAll();

        return [
            'users' => $users,
            'sexes' => $this->getSex($users),
            'avators' => $this->getAvators($users),
        ];
    }
}
