<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\Admin\UserRepositoryContract;
use App\Http\Controllers\Controller;
use App\ViewModels\Admin\User\IndexViewModel;
use App\ViewModels\Admin\User\ShowViewModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SendInviteMail;
use Mail;
use App\Mail\Invite;

class UserController extends Controller
{
    private $id;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository  = $userRepository;
    }

    public function index(IndexViewModel $viewModel)
    {
        return $viewModel->render('admin.users.index');
    }

    public function show(int $id, ShowViewModel $viewModel)
    {
        $viewModel->setId($id);

        return $viewModel->render('admin.users.show');
    }
}
