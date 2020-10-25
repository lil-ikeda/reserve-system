<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Http\Controllers\Controller;
use App\ViewModels\Admin\User\ShowViewModel;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SendInviteMail;
use Mail;
use App\Mail\Invite;


class UserController extends Controller
{
    private $id;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository  = $adminRepository;
    }

    public function show(ShowViewModel $viewModel)
    {
        $viewModel->setId(Auth::id());

        return $viewModel->render('admin.users.show');
    }

    public function destroy()
    {
        $this->adminRepository->destroy(Auth::id());

        return redirect(route('admin.events.index'));
    }

    /**
     * 招待ページ
     */
    public function invite()
    {
        return view('admin.users.invite');
    }

    /**
     * 招待メールを送信
     */
    public function sendInviteMail(SendInviteMail $request)
    {
        Mail::to($request->input('email'))->send(new Invite());

        return redirect(route('admin.users.invite'));
    }
}
