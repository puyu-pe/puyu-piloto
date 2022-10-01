<?php

namespace App\Saas\Shared\Domain\Notification;

class NotificationText
{
    public function __construct(
        private ?string $value
    ) {
    }

    /**
     * @return string|null
     */
    public function value(): ?string
    {
        return $this->value;
    }
}
