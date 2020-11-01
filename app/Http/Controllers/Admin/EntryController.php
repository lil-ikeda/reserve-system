<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\Admin\EntryRepositoryContract;
use App\Contracts\Repositories\Admin\UserRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyEntry;
use Illuminate\Support\Facades\Mail;
use App\Mail\CancelCompleted;

class EntryController extends Controller
{
    public function __construct(EntryRepositoryContract $entryRepository, UserRepositoryContract $userRepository)
    {
        $this->entryRepository  = $entryRepository;
        $this->userRepository  = $userRepository;
    }

    public function destroy(DestroyEntry $request)
    {
        $eventId = $request->input('eventId');
        $userId = $request->input('userId');
        $user = $this->userRepository->findById($userId);

        // 「エントリー」レコードの削除
        $this->entryRepository->destroy(
            $eventId,
            $userId
        );

        // キャンセル完了メール
        Mail::to($user->email)->send(new CancelCompleted);

        return redirect(route('admin.events.show', $eventId));
    }
}
