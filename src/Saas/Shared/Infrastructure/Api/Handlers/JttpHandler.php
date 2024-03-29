<?php

namespace App\Saas\Shared\Infrastructure\Api\Handlers;

/**
 *
 * This file is part of a repository on GitHub.
 *
 * (c) Riccardo De Martis <riccardo@demartis.it>
 *
 * <https://github.com/demartis>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

use App\Saas\Shared\Domain\Exception\DomainError;
use App\Saas\Shared\Infrastructure\Api\Utils\Jttp;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JttpHandler
{
    use LoggerAwareTrait;

    public function __construct(LoggerInterface $logger)
    {
        $this->setLogger($logger);
    }

    public function createResponse(ViewHandler $handler, View $view, Request $request, string $format): Response
    {
        if ($this->isSuccessful($view)) {
            $response = $handler->createResponse($view, $request, 'json');
            $content = $response->getContent() ?: '';
            $jttpContent = Jttp::success(json_decode($content, true))->toJson();
        } else {
            if (method_exists($view->getData(), 'errorMessage')) {
                if ($view->getData() instanceof DomainError) {
                    $exception = $view->getData();
                    $errorContent = [$exception->errorCode() => $exception->errorMessage()];
                } else {
                    $errorContent = ['data' => $view->getData()];
                }
                $jttpContent = Jttp::fail($view->getStatusCode(), null, $errorContent)->toJson();
            } else {
                $errorContent["data"] = $view->getData();
                $jttpContent = Jttp::error($view->getStatusCode(), null, $errorContent)->toJson();
            }
            $response = new Response($jttpContent, $view->getStatusCode(), $view->getHeaders());
        }

        $response->setContent($jttpContent);
        return $response;
    }

    private function isSuccessful(View $view): bool
    {
        return $view->getStatusCode() >= 200 && $view->getStatusCode() < 300;
    }
}
