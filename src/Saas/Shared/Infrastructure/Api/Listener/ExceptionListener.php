<?php

namespace App\Saas\Shared\Infrastructure\Api\Listener;

use App\Saas\Shared\Infrastructure\Api\Utils\Jttp;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Description of ExceptionListener
 *
 * @author Riccardo De Martis <riccardo@demartis.it>
 */
class ExceptionListener
{
    use LoggerAwareTrait;

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $type = get_class($throwable);

        if (method_exists($throwable, 'getStatusCode')) {
            $statusCode = $throwable->getStatusCode();
        } else {
            $statusCode = match ($type) {
                'Symfony\Component\Routing\Exception\ResourceNotFoundException' => Response::HTTP_NOT_FOUND,
                'Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException' => Response::HTTP_NOT_IMPLEMENTED,
                default => Response::HTTP_INTERNAL_SERVER_ERROR,
            };
        }

        $error = [];
        $message = $throwable->getMessage();

        if (gettype($message) == 'string') {
            $error['detail'] = $message;
        } else {
            $error = $message;
        }


        $content = Jttp::error($statusCode, null, $error)->toArray();

        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $jsonContent = json_encode($content) ?: '';

        if (json_last_error() != JSON_ERROR_NONE) {
            $jsonContent = "['error converting to json: " . json_last_error_msg() . "']";
        }
        $response->setContent($jsonContent);
        $event->setResponse($response);
    }
//
//    /**
//     * Creates the ApiResponse from any Exception
//     *
//     * @param \Throwable $exception
//     *
//     * @return ApiResponse
//     */
//    private function createApiResponse(\Exception $exception)
//    {
//        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
//        $errors = [];
//
//        return new ApiResponse($exception->getMessage(), null, $errors, $statusCode);
//    }
}
