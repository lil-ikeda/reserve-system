<?php

namespace App\ViewModels\Admin\Event;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\EventRepositoryContract;

class ShowViewModel extends ViewModel
{
    /**
     * イベントリポジトリ
     *
     * @var
     */
    private $eventRepository;

    /**
     * イベントID
     *
     * @var
     */
    private $id;

    public function __construct(EventRepositoryContract $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function toMap(): array
    {
        $id = $this->getId() ?? 0;

        return [
            'event' => $this->eventRepository->findById($id),
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
