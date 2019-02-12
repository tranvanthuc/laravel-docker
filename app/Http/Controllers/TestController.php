<?php

namespace App\Http\Controllers;

use App\Services\FireBase\CloudMessaging;
use App\Services\FireBase\RealtimeDB;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $realtimeDB;

    protected $cloudMessaging;

    public function __construct()
    {
        $this->realtimeDB     = app(RealtimeDB::class);
        $this->cloudMessaging = app(CloudMessaging::class);
    }

    public function index()
    {
        $data = " true ";
        //        $params = [
        //            'user_id' => 2,
        //            'message' => 'Test firebase '
        //        ];
        //
                $this->firebaseService->create("notifications", $params);

//                $data = $this->realtimeDB->getKeyValueByParent("notifications", ['user_id', 1]);

//        $this->cloudMessaging->send("Hello");

        return $data;
    }
}
