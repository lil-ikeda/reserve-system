<?php
declare(strict_types=1);

namespace App\ViewModels\User;

use App\Models\Entry;
use App\Models\Event;
use App\ViewModels\User\Base\ViewModel;
use Illuminate\Database\Eloquent\Collection;

class EventShowViewModel extends ViewModel
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

    // public static function collect($events)
    // {
    //     return $events
    //         ->map(fn(Event $event) => new self($event));
    // }

    public function toMap(): array
    {
        $entry = $this->event->entries->first();

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
            'isFree' => $this->event->price === $this->event::FREE,
            'entryButtonStatus' => $this->getEntryStatus($entry),
            'paymentButtonStatus' => $this->getPaymentStatus($entry)
        ];
    }

    // エントリーステータス
    private const FOR_ENTRY = 0;     //「エントリーページへ」
    private const FOR_CANCEL = 1;   //「エントリーをキャンセルする」
    private const WAITING_LIST = 2; //「キャンセル待ち」

    // 支払いステータス
    private const BUTTON_NONE = 0;        // ボタン表示なし
    private const PAY_IN_PAYPAY = 1;      //「PayPayで支払う」
    private const PAY_IN_BANK = 2;        //「振込先情報を表示」
    private const PAID = 3;               //「支払済」
    private const FREE = 4;               //「無料イベントにつき支払不要」
    private const WAITING_FOR_REFUND = 5; //「返金待ち」
    
    /**
     * エントリーボタンの表示用ステータスを取得
     *
     * @param ?Entry $entry
     * @return integer
     */
    private function getEntryStatus(?Entry $entry): int
    {
        if (is_null($entry)) {
            $entryButtonStatus = self::FOR_ENTRY;
        } else {
            if ((bool)$entry->cancellation_request === true) {
                $entryButtonStatus = self::WAITING_LIST;
            } elseif ((bool)$entry->cancellation_request === false) {
                $entryButtonStatus = self::FOR_CANCEL;
            }
        }
        return $entryButtonStatus;
    }

    /**
     * 支払いボタンのステータスを取得
     *
     * @param ?Entry $entry
     * @return integer
     */
    private function getPaymentStatus(?Entry $entry): int
    {
        // イベントが無料の場合
        if ($this->event->price === Event::FREE) {
            $paymentButtonStatus = self::FREE;
            return $paymentButtonStatus;
        }

        // エントリーしていない場合
        if (is_null($entry)) {
            $paymentButtonStatus = self::BUTTON_NONE;
            return $paymentButtonStatus;
        }

        // キャンセル希望がある場合
        if ((bool)$entry->cancellation_request === true) {
            if ((bool)$entry->paid === true) {
                $paymentButtonStatus = self::WAITING_FOR_REFUND;
            } elseif ((bool)$entry->paid === false) {
                $paymentButtonStatus = self::BUTTON_NONE;
            }
            return $paymentButtonStatus;
        }

        // 有料イベント・エントリー済み・キャンセル希望なしの場合
        if ((bool)$entry->paid === true) {
            $paymentButtonStatus = self::PAID;
        } else {
            if ($entry->payment_method === config('const.payment_method.paypay')) {
                $paymentButtonStatus = self::PAY_IN_PAYPAY;
            } elseif ($entry->payment_method === config('const.payment_method.bank')) {
                $paymentButtonStatus = self::PAY_IN_BANK;
            }
        }
        return $paymentButtonStatus;
    }
}