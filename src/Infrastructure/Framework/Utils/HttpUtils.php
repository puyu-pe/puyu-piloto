<?php

namespace App\Infrastructure\Framework\Utils;

use Symfony\Component\HttpFoundation\Response;

class HttpUtils
{
    public static function getStatusCode200(): int
    {
        return Response::HTTP_OK;
    }

    public static function getHttpStatus(int $httpCode): string
    {
        return Response::$statusTexts[$httpCode] ?? '';
    }
}
