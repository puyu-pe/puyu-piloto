<?php

namespace App\Domain\Notification;

class NotificationSender
{
    public function __construct(private readonly Notifier $notifier)
    {
    }

    public function __invoke(NotificationText $text, NotificationType $action): void
    {
        $this->notifier->notify($text, $action);
    }
}