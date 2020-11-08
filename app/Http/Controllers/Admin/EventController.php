<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\EventRepositoryContract;
use App\ViewModels\Admin\Event\ShowViewModel;
use App\Http\Controllers\Controller;
use App\ViewModels\Admin\Event\IndexViewModel;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;

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


    public function create()
    {
        return view('admin.events.create');
    }

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
     * イベント詳細
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

    public function destroy(int $id)
    {
        $this->eventRepository->destroy($id);

        return redirect(route('admin.events.index'));
    }
}
