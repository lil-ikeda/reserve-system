<?php

namespace App\ViewModels\Admin\Event;

use App\ViewModels\Base\ViewModel;
use App\Contracts\Repositories\EventRepositoryContract;
use App\Contracts\Repositories\EntryRepositoryContract;

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

    /**
     * ユーザーアイコンの取得
     *
     * @param $users
     * @return array
     */
    private function getAvators($users)
    {
        $avators = [];
        foreach ($users as $user) {
            if (is_null($user->avator)) {
                $avators[$user->id] = 'img/noavator.png';
            } else {
                $avators[$user->id] = 'img/noavator.png';
            }
        }
        return $avators;
    }

    public function toMap(): array
    {
        $id = $this->getId() ?? 0;

        $entries = $this->entryRepository->getByEventId($id);
        $users = $this->eventRepository->getEntriedUsers($id);

        return [
            'event' => $this->eventRepository->findById($id),
            'users' => $users,
            'shippingStatus' => $this->eventRepository->getShippingStatus($entries),
            'cancellationRequests' => $this->eventRepository->getCancellationRequest($entries),
            'paymentMethods' => $this->eventRepository->getPaymentMethod($entries),
            'avators' => $this->getAvators($users),
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
