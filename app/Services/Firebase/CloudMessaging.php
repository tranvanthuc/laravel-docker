<?php

namespace App\Services\FireBase;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class CloudMessaging extends FirebaseService
{
    protected $messaging;


    public function __construct()
    {
        parent::__construct();
        $this->messaging = $this->firebase->getMessaging();
    }

    public function send($content)
    {
        $topic = 'a-topic';

        $title = $content;
        $body  = 'My Notification Body';

        $notification = Notification::create($title, $body);
        $message      = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)// optional
        ;

        $this->messaging->send($message);

    }
}
