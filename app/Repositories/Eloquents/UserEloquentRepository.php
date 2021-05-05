<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Repositories\Params\UserParams;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Ramsey\Collection\Collection;
use Illuminate\Support\Facades\Storage;

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
     * 全ユーザーをペジネーションで取得
     *
     * @return Paginator
     */
    public function getAll(): Paginator
    {
        $users = $this->user->with('circle')->paginate(15);

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

    /**
     * ユーザーのプロフィールを更新
     *
     * @param integer $userId
     * @param UserParams $userParams
     * @return void
     */
    public function update(int $userId, UserParams $userParams): void
    {
        $user = $this->findById($userId);
        $image = $userParams->getFile();
        // S3へのアップロード
        if(!is_null($image)) {
            $path = Storage::disk('s3')->putfile('/users/avatar', $image, 'public');
            $url = Storage::disk('s3')->url($path);
            $storePath = '/users/avatar/' . basename(parse_url($url, PHP_URL_PATH));
        }

        $user->update([
            'avatar' => $storePath ?? '',
            'name' => $userParams->getName(),
            'email' => $userParams->getEmail(),
            'phone' => $userParams->getPhone(),
            'circle_id' => $userParams->getCircleId(),
            'birthday' => $userParams->getBirthday(),
            'sex' => $userParams->getSex()
        ]);
    }
}
