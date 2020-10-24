<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Http\Controllers\Controller;
use App\ViewModels\Admin\User\ShowViewModel;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

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
}
