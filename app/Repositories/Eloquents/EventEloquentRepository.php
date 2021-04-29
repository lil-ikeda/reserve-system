<?php

namespace App\Repositories\Eloquents;

use App\Models\Event;
use App\Models\Entry;
use App\Contracts\Repositories\EventRepositoryContract;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\OrderItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EventEloquentRepository implements EventRepositoryContract
{
    /**
     * イベントモデル
     *
     * @var Event
     */
    private $event;

    /**
     * エントリーモデル
     *
     * @var
     */
    private $entry;


    /**
     * construct
     *
     * EventEloquentRepository constructor.
     * @param Event $event
     */
    public function __construct(Event $event, Entry $entry)
    {
        $this->event = $event;
        $this->entry = $entry;
    }

    /**
     * 全てのイベントを取得
     *
     * @return array
     */
    public function getAll(): LengthAwarePaginator
    {
        $events = $this->event->orderBy('date', 'desc')->paginate(15);
        return $events;
    }

    /**
     * ユーザー画面用にイベントを全て取得
     *
     * @return LengthAwarePaginator
     */
    public function getAllForUser(): LengthAwarePaginator
    {
        $yesterday = CarbonImmutable::yesterday();
        
        return $this->event
            ->where('date', ">=", $yesterday)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * IDからイベントを取得
     *
     * @param int $id
     * @return Arrayable
     */
    public function findById(int $id): Arrayable
    {
        return $this->event->find($id);
    }

    /**
     * IDからユーザー情報とともに特定のイベントを取得
     *
     * @param integer $id
     * @return Collection|null
     */
    public function findWithUsers(int $id): ?Event
    {
        return $this->event->with('users')->find($id);
    }

    /**
     * IDから特定のイベントと紐づくユーザー情報を取得
     *
     * @param integer $id
     * @return Arrayable
     */
    public function findWithUserCounts(int $id): Arrayable
    {
        return $this->event
            ->withCount('users')
            ->with(['entries' => function($query) use ($id) {
                $query->where('user_id', Auth::id())
                    ->where('event_id', $id)
                    ->first();
            }])
            ->findOrFail($id);
    }

    /**
     * イベントの保存
     *
     * @param string $name
     * @param string $description
     * @param string $date
     * @param string $openTime
     * @param string $closeTime
     * @param string $place
     * @param int $price
     * @param object $image
     */
    public function store(
        string $name,
        string $description,
        string $date,
        string $openTime,
        string $closeTime,
        string $place,
        int $price,
        object $image = null
    ): void {
        $this->event->name = $name;
        $this->event->description = $description;
        $this->event->date = $date;
        $this->event->open_time = $openTime;
        $this->event->close_time = $closeTime;
        $this->event->place = $place;
        $this->event->price = $price;

        if(!is_null($image)) {
            $path = Storage::disk('s3')->putfile('/', $image, 'public');
            $url = Storage::disk('s3')->url($path);
            $this->event->image = '/' . basename(parse_url($url, PHP_URL_PATH));
        }

        $this->event->save();
    }

    /**
     * イベントの更新
     *
     * @param string $name
     * @param string $description
     * @param string $date
     * @param string $openTime
     * @param string $closeTime
     * @param string $place
     * @param int $price
     * @param object $image
     */
    public function update(
        int $id,
        string $name,
        string $description,
        string $date,
        string $openTime,
        string $closeTime,
        string $place,
        int $price,
        object $image = null
    ): void {
        $event = $this->findById($id);

        $event->name = $name;
        $event->description = $description;
        $event->date = $date;
        $event->open_time = $openTime;
        $event->close_time = $closeTime;
        $event->place = $place;
        $event->price = $price;

        if (!is_null($image)) {
            $path = Storage::disk('s3')->putfile('/', $image, 'public');
            $url = Storage::disk('s3')->url($path);
            $event->image = '/' . basename(parse_url($url, PHP_URL_PATH));
        }

        $event->save();
    }

    /**
     * エントリー済みのユーザーを取得
     *
     * @param int $id
     * @return Collection
     */
    public function getEntriedUsers(int $id): Collection
    {
        return $this->findById($id)->users;
    }

    /**
     * 支払ステータスを取得
     *
     * @param object $entries
     * @return array
     */
    public function getShippingStatus(object $entries): array
    {
        $shippingStatus = [];
        foreach ($entries as $entry) {
            $shippingStatus[$entry->user_id] = $entry->paid;
        }

        return $shippingStatus;
    }

    /**
     * キャンセル希望有無を取得
     *
     * @param $entries
     * @return array
     */
    public function getCancellationRequest(object $entries): array
    {
        $cancellationRequests = [];
        foreach ($entries as $entry) {
//            switch ($entry->cancellation_request) {
//                case false:
//                    $cancellationRequests[$entry->user_id] = '-';
//                    break;
//                case true:
//                    $cancellationRequests[$entry->user_id] = 'キャンセル待ち';
//                    break;
//            }
            $cancellationRequests[$entry->user_id] = $entry->cancellation_request;
        }

        return $cancellationRequests;
    }

    /**
     * 支払方法を取得
     *
     * @param object $entries
     * @return array
     */
    public function getPaymentMethod(object $entries): array
    {
        $paymentMethods = [];
        foreach ($entries as $entry) {
            switch ($entry->payment_method) {
                case config('const.payment_method.paypay.id'):
                    $paymentMethods[$entry->user_id] = 'PayPay';
                    break;
                case config('const.payment_method.bank.id'):
                    $paymentMethods[$entry->user_id] = '口座振込';
                    break;
                case config('const.payment_method.free.id'):
                    $paymentMethods[$entry->user_id] = '支払情報なし';
                    break;
            }
        }

        return $paymentMethods;
    }

    /**
     * イベントを削除
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->event->destroy($id);
    }


    /**
     * PayPay決済
     *
     * @param string $eventName
     * @param int $eventPrice
     * @param int $eventId
     * @throws \PayPay\OpenPaymentAPI\ClientException
     * @throws \PayPay\OpenPaymentAPI\Controller\ClientControllerException
     * @throws \PayPay\OpenPaymentAPI\Models\ModelException
     */
    public function pay(string $eventName, int $eventPrice, int $eventId): string
    {
        // クライアントのビルド
        $this->paypayClient = new Client([
            'API_KEY' => config('const.paypay.apikey'),
            'API_SECRET'=> config('const.paypay.secret'),
            'MERCHANT_ID'=> config('const.paypay.merchant'),
        ]);

        // setup payment object
        $CQCPayload = new CreateQrCodePayload();
        // Set merchant pay identifier
        $CQCPayload->setMerchantPaymentId("skillhack_transaction_" . \time());
        // Log time of request
        $CQCPayload->setRequestedAt();
        // Indicate you want QR Code
        $CQCPayload->setCodeType("ORDER_QR");

        // イベントの名前と金額を登録
        $orderItems = [];
        $orderItems[] = (new OrderItem())
            ->setName($eventName)
            ->setQuantity(1)
            ->setUnitPrice(['amount' => $eventPrice, 'currency' => 'JPY']);
        $CQCPayload->setOrderItems($orderItems);

        // Save Cart totals
        $amount = [
            "amount" => $eventPrice,
            "currency" => "JPY"
        ];
        $CQCPayload->setAmount($amount);

        // Configure redirects
        $CQCPayload->setRedirectType('WEB_LINK');
        $CQCPayload->setRedirectUrl(route('user.event.paid', $eventId));
        $CQCPayload->setUserAgent('Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1');

        //=================================================================
        // Calling the method to create a qr code
        //=================================================================
        $response = $this->paypayClient->code->createQRCode($CQCPayload);

        // 処理がうまくいってなかったら抜ける
        if ($response['resultInfo']['code'] !== 'SUCCESS') {
            return false;
        }

        // Collectionに変換しておく
        $QRCodeResponse = collect($response['data']);

        // 決済ページのURLを返却
        return $QRCodeResponse['url'];
    }
}
