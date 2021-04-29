<?php
declare(strict_types=1);

namespace App\ViewModels\User;

use App\Models\Event;
use App\ViewModels\User\Base\ViewModel;

class EventViewModel extends ViewModel
{
    /**
     * イベント
     * @var Event
     */
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public static function collect($events)
    {
        return $events
            ->map(fn(Event $event) => new self($event));
    }

    public function toMap(): array
    {
        return [
            'id' => $this->event->id,
            'name' => $this->event->name,
            'description' => $this->event->description,
            'date' => date('Y年m月d日', strtotime($this->event->date)),
            'openTime' => date('H:i', strtotime($this->event->open_time)),
            'closeTime' => date('H:i', strtotime($this->event->close_time)),
            'place' => $this->event->place,
            'price' => $this->event->price,
            'image' => $this->event->image,
            'usersCount' => $this->event->users_count,
            'url' => route('user.events.show', $this->event->id),
            'isFree' => $this->event->price === $this->event::FREE
        ];
    }
}