<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\EventRepositoryContract;
use App\Mail\ToAllEntryUsers;
use App\ViewModels\Admin\Event\ShowViewModel;
use App\Http\Controllers\Controller;
use App\ViewModels\Admin\Event\IndexViewModel;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Http\Requests\Admin\SendMailToEntries;
use App\ViewModels\Admin\Event\CreateMailViewModel;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /**
     * イベントリポジトリ
     *
     * @var EventRepositoryContract
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
        $this->eventRepository  = $eventRepository;
    }

    /**
     * イベント一覧
     *
     * @param IndexViewModel $viewModel
     * @return \Illuminate\View\View
     */
    public function index(IndexViewModel $viewModel)
    {
        return $viewModel->render('admin.events.index');
    }


    /**
     * イベント作成画面へ遷移
     *
     * @return void
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * イベントの保存
     *
     * @param StoreEvent $request
     * @return void
     */
    public function store(StoreEvent $request)
    {
        $name = $request->name;
        $description = $request->description;
        $date = $request->date;
        $openTime = $request->open_time;
        $closeTime = $request->close_time;
        $place = $request->place;
        $price = $request->price;
        $image = $request->file('image');

        $this->eventRepository->store(
            $name,
            $description,
            $date,
            $openTime,
            $closeTime,
            $place,
            $price,
            $image
        );

        return redirect()->route('admin.events.index');
    }

    /**
     * イベント詳細画面へ遷移
     *
     * @param ShowViewModel $viewModel
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(ShowViewModel $viewModel, int $id)
    {
        $viewModel->setId($id);

        return $viewModel->render('admin.events.show');
    }

    /**
     * イベント更新
     *
     * @param UpdateEvent $request
     * @param integer $id
     * @return void
     */
    public function update(UpdateEvent $request, int $id)
    {
        $name = $request->name;
        $description = $request->description;
        $date = $request->date;
        $openTime = $request->open_time;
        $closeTime = $request->close_time;
        $place = $request->place;
        $price = $request->price;
        $image = $request->file('image');

        $this->eventRepository->update(
            $id,
            $name,
            $description,
            $date,
            $openTime,
            $closeTime,
            $place,
            $price,
            $image
        );

        return redirect()->route('admin.events.index');
    }

    /**
     * イベントの削除
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        $this->eventRepository->destroy($id);

        return redirect(route('admin.events.index'));
    }

    /**
     * エントリー者への一斉メール作成画面
     *
     * @param CreateMailViewModel $viewModel
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function mail(CreateMailViewModel $viewModel, int $id)
    {
        $viewModel->setId($id);

        return $viewModel->render('admin.events.mail');
    }

    /**
     * イベントの参加者全員にメールを送信する
     *
     * @param SendMailToEntries $request
     * @param integer $id
     * @return void
     */
    public function sendMail(SendMailToEntries $request, int $id)
    {
        $userNames = $request->input('user_names');
        $userMails = $request->input('user_mails');
        $numberOfUsers = count($userNames);

        for ($i = 0; $i < $numberOfUsers; $i++) {
            Mail::to($userMails[$i])
                ->send(new ToAllEntryUsers(
                    $userNames[$i],
                    $request->input('subject'),
                    $request->input('text')
                ));
        }

        return redirect(route('admin.events.show', $id));
    }
}
