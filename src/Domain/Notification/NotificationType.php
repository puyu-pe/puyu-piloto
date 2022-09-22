<?php

namespace App\Domain\Notification;

class NotificationType
{
    public ?string $value = null;
    public const PROJECT_CRATED = 'project_created';

    public function __construct()
    {
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
