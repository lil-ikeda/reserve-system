<?php
namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\CircleRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\ViewModels\User\UserViewModel;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
    /**
     * イベントリポジトリ
     *
     * @var CircleRepositoryContract
     */
    private $circleRepository;

    /**
     * ユーザーリポジトリ
     *
     * @var UserRepositoryContract
     */
    private $userRepository;

    public function __construct(
        CircleRepositoryContract $circleRepository,
        UserRepositoryContract $userRepository
    )
    {
        $this->circleRepository = $circleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * マイページの表示
     *
     * @return void
     */
    public function myPage()
    {
        $user = Auth::user();
        $circles = $this->circleRepository->getAll()->toArray();

        return view('user.users.mypage')
            ->with([
                'user' => (new UserViewModel($user))->toArray(),
                'circles' => $circles
            ]);
    }
    
    /**
     * プロフィールの更新
     *
     * @param UpdateUser $request
     * @return void
     */
    public function update(UpdateUser $request)
    {
        $this->userRepository->update(Auth::id(), $request->getParams());
        
        return redirect(route('user.users.mypage'))
            ->with('flash_message', trans('message.success.user.update'));
    }
}
