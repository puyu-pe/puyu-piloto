<?php

namespace App\Infrastructure\Notifier;

use App\Domain\Notification\NotificationText;
use App\Domain\Notification\NotificationType;
use App\Domain\Notification\Notifier;

use function Lambdish\Phunctional\get;

class GmailNotifier implements Notifier
{
    private $client;

    public function __construct()
    {
    }

    public function notify(NotificationText $text, NotificationType $action)
    {
        //
    }
}