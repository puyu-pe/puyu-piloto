<?php

namespace App\Saas\Shared\Domain\Notification;

interface Notifier
{
    public function notify(NotificationText $text, NotificationType $action): void;
}
