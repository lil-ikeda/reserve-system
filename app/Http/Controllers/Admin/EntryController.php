<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\EntryRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyEntry;
use Illuminate\Support\Facades\Mail;
use App\Mail\CancelCompleted;

class EntryController extends Controller
{
    public function __construct(
        EntryRepositoryContract $entryRepository,
        UserRepositoryContract $userRepository,
        EventRepositoryContract $eventRepository
    ) {
        $this->entryRepository  = $entryRepository;
        $this->userRepository  = $userRepository;
        $this->eventRepository  = $eventRepository;
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

        $eventName = $this->eventRepository->findByid($eventId)->name;

        // キャンセル完了メール
        Mail::to($user->email)->send(new CancelCompleted($eventName, $user->name));

        return redirect(route('admin.events.show', $eventId));
    }
}
