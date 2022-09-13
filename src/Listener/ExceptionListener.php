<?php
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

namespace App\Listener;

use App\Utils\Jttp\Jttp;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;


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

        if(method_exists($throwable, 'getStatusCode')){
            $statusCode = $throwable->getStatusCode();
        }else{
            $statusCode = match ($type) {
                ResourceNotFoundException::class => Response::HTTP_NOT_FOUND,
                UnsupportedMediaTypeHttpException::class => Response::HTTP_NOT_IMPLEMENTED,
                default => Response::HTTP_INTERNAL_SERVER_ERROR,
            };
        }

        $error=[];
        if ($type === 'App\Exception\FormException') {
            $data = [];
            /** @var FormErrorIterator $errors */
            $errors = $throwable->getErrors();
            foreach ($errors as $e) {
                $data[$e->getOrigin()->getName()] = $e->getMessage();
            }
            $error['form'] = $data;
        } else {
            $message = $throwable->getMessage();
            if (gettype($message) === 'string') {
                $error['detail'] = $message;
            } else {
                $error = $message;
            }
        }


        $content=Jttp::error($statusCode, null, $error)->toArray();

        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $jsonContent = json_encode($content);

        if (json_last_error() != JSON_ERROR_NONE) {
            $jsonContent = "['error converting to json: ".json_last_error_msg()."']";
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