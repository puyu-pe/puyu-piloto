<?php

namespace App\Domain\Notification;

class NotificationType
{
    public ?string $value = null;
    public const VIDEO_CRATED = 'customer_contact_created';

    public function __construct()
    {
    }

    public function value(): ?string
    {
        return $this->value;
    }
}