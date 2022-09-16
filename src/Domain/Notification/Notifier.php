<?php

namespace App\Domain\Notification;

interface Notifier
{
    public function notify(NotificationText $text, NotificationType $action);
}