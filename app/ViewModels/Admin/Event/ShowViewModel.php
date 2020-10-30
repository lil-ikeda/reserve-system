<?php

namespace App\ViewModels\Admin\Event;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\Admin\EventRepositoryContract;
use App\Contracts\Repositories\Admin\EntryRepositoryContract;

class ShowViewModel extends ViewModel
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

        $entries = $this->entryRepository->getByEventId($id);


        return [
            'event' => $this->eventRepository->findById($id),
            'users' => $this->eventRepository->getEntriedUsers($id),
            'shippingStatus' => $this->eventRepository->getShippingStatus($entries),
            'cancellationRequests' => $this->eventRepository->getCancellationRequest($entries),
            'paymentMethods' => $this->eventRepository->getPaymentMethod($entries),
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
