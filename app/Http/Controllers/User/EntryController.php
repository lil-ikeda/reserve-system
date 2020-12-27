<?php

namespace App\Http\Controllers\User;

use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Contracts\Repositories\EntryRepositoryContract;

class EntryController extends Controller
{
    /**
     * イベントリポジトリ
     *
     * @var EventRepositoryContract
     */
    private $eventRepository;

    /**
     * エントリーリポジトリ
     *
     * @var
     */
    private $entryRepository;

    public function __construct(EventRepositoryContract $eventRepository, EntryRepositoryContract $entryRepository)
    {
        $this->middleware('verified')->except(['index', 'show']);
        $this->eventRepository  = $eventRepository;
        $this->entryRepository  = $entryRepository;
    }

    public function get(int $id)
    {
//        $entry = $this->entryRepository->getByEventAndUserId($id, Auth::id());
        $entry = Entry::where('event_id', $id)->where('user_id', Auth::id())->first();

        return $entry;
    }
}
