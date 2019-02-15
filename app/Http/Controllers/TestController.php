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
        $data   = " true ";
        $params = [
            'user_id' => 5,
            'message' => 'Test firebase '
        ];

        $data = $this->realtimeDB->create("notifications", $params);
//        $key  = $data->getKey();

//        $value = $this->realtimeDB->db()->getReference('notifications')->getValue();
//        dd($data->getKey());


        //                $data = $this->realtimeDB->getKeyValueByParent("notifications", ['user_id', 1]);

        //        $this->cloudMessaging->send("Hello");

        return $data;
    }

    public function realtime()
    {
        $value = $this->realtimeDB->db()->getReference('notifications')->getSnapshot();
        dd($value->getValue());
        return $value;
    }
}
