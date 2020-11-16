<?php

namespace App\ViewModels\Admin\Event;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Contracts\Repositories\EntryRepositoryContract;

class CreateMailViewModel extends ViewModel
{
    /**
     * イベントリポジトリ
     *
     * @var
     */
    private $eventRepository;

    /**
     * イベントリポジトリ
     *
     * @var
     */
    private $entryRepository;

    /**
     * イベントID
     *
     * @var
     */
    private $id;

    public function __construct(EventRepositoryContract $eventRepository, EntryRepositoryContract $entryRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->entryRepository = $entryRepository;
    }

    public function toMap(): array
    {
        $id = $this->getId() ?? 0;
        $event = $this->eventRepository->findById($id);

        return [
            'event' => $event,
            'entriedUsers' => $this->eventRepository->getEntriedUsers($id),
            'text' =>
                $event->name . "の開催が近づいてまいりましたので、確認のためご連絡をいたしました。\n\n■イベント情報\n日程：$event->date\n時間：$event->open_time 〜 $event->close_time\n場所：$event->price\n"
        ];
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
