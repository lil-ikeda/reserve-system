<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $response = array();

        $eventQuery = Event::query();
        $events = $eventQuery->get();
        $response['events'] = $events;
        $response['message'] = 'success';

        return new JsonResponse($response);
    }
}
