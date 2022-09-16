<?php

namespace App\Infrastructure\Notifier;

use App\Domain\Notification\NotificationText;
use App\Domain\Notification\NotificationType;
use App\Domain\Notification\Notifier;
use Maknz\Slack\Client;

use function Lambdish\Phunctional\get;

class SlackNotifier implements Notifier
{
    public const UNKNOWN_NOTIFICATION = 'NOTIFICATION';

    private static array $actionFaces = [
        NotificationType::VIDEO_CRATED => ':D element crated!'
    ];

    private Client $client;

    public function __construct(string $hookUrl, array $setting)
    {
        $this->client = new Client($hookUrl, $setting);
    }

    public function notify(NotificationText $text, NotificationType $action): void
    {
        $message = $this->client->createMessage();

        $message->setText(
            sprintf('%s %s', get($action->value(), self::$actionFaces, self::UNKNOWN_NOTIFICATION), $text->value())
        );

        $this->client->sendMessage($message);
    }
}