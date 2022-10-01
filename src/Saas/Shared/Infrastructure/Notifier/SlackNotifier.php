<?php

namespace App\Saas\Shared\Infrastructure\Notifier;

use App\Saas\Shared\Domain\Notification\NotificationText;
use App\Saas\Shared\Domain\Notification\NotificationType;
use App\Saas\Shared\Domain\Notification\Notifier;
use Maknz\Slack\Client;

use function Lambdish\Phunctional\get;

class SlackNotifier implements Notifier
{
    public const UNKNOWN_NOTIFICATION = 'NOTIFICATION';

    /**
     * @var array|string[]
     */
    private static array $actionFaces = [
        NotificationType::PROJECT_CRATED => ':D element created!'
    ];

    private Client $client;

    /**
     * @param string $hookUrl
     * @param array|string[] $setting
     */
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
