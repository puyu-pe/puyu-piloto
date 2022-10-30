<?php

namespace App\Saas\Shared\Infrastructure\Api\Utils;

use App\Saas\Shared\Infrastructure\Api\Utils\Exception\InternalJttpException;
use App\Saas\Shared\Infrastructure\Api\Utils\Exception\MalformedJttpException;

final class Jttp
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAIL = 'fail';
    public const STATUS_ERROR = 'error';

    public const FIELD_STATUS = 'status';
    public const FIELD_CODE = 'code';
    public const FIELD_MESSAGE = 'message';
    public const FIELD_DATA = 'data';
    public const FIELD_ERROR = 'error';


    /**
     * JttpResponse constructor.
     * @throws MalformedJttpException
     */
    public function __construct(
        protected string $status,
        protected int $code,
        protected ?string $message,
        /**
         * @var array<mixed>|null
         */
        protected ?array $data = null,
        /**
         * @var array<string>|null
         */
        protected ?array $error = null
    ) {
        if (!$this->isValidStatus($status)) {
            throw new MalformedJttpException('Status does not conform to Jttp spec.');
        }

        if ($status == Jttp::STATUS_SUCCESS && !is_null($error)) {
            throw new MalformedJttpException('Field "error" must be set only in "error" statuses.');
        }

        if ($status == Jttp::STATUS_ERROR && !is_null($data)) {
            throw new MalformedJttpException('Field "data" must be set only in "success" statuses.');
        }

        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->error = $error;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $res = [];

        $res[self::FIELD_STATUS] = $this->status;
        //        $res[self::FIELD_CODE]=$this->code;
        //        $res[self::FIELD_MESSAGE]=$this->message;
        switch ($this->status) {
            case self::STATUS_SUCCESS:
            case self::STATUS_FAIL:
                $res[self::FIELD_DATA] = $this->data;
                break;
            case self::STATUS_ERROR:
                $res[self::FIELD_ERROR] = $this->error;
                break;
            default:
                throw new InternalJttpException('Unknown status code');
        }

        return $res;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray()) ?: '';
    }

    /**
     * @param array<mixed>|null $data
     */
    public static function success(array $data = null): Jttp
    {
        return new Jttp(
            Jttp::STATUS_SUCCESS,
            HttpUtils::getStatusCode200(),
            HttpUtils::getHttpStatus(HttpUtils::getStatusCode200()),
            $data
        );
    }

    /**
     * @param int $statusCode
     * @param string|null $statusCodeMessage
     * @param array<mixed>|null $data
     * @return Jttp
     */
    public static function fail(int $statusCode, ?string $statusCodeMessage = null, ?array $data = null): Jttp
    {
        return new Jttp(
            Jttp::STATUS_FAIL,
            $statusCode,
            $statusCodeMessage == null ? HttpUtils::getHttpStatus($statusCode) : $statusCodeMessage,
            $data
        );
    }

    /**
     * @param int $statusCode
     * @param string|null $statusCodeMessage
     * @param array<string>|null $error
     * @return Jttp
     */
    public static function error(int $statusCode, ?string $statusCodeMessage = null, array $error = null): Jttp
    {
        return new static(
            static::STATUS_ERROR,
            $statusCode,
            $statusCodeMessage == null ? HttpUtils::getHttpStatus($statusCode) : $statusCodeMessage,
            null,
            $error
        );
    }


    protected function isValidStatus(string $status): bool
    {
        $validStatuses = array(static::STATUS_SUCCESS, static::STATUS_FAIL, static::STATUS_ERROR);
        return \in_array($status, $validStatuses, true);
    }

    public function isValidJson(string $string): bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
