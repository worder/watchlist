<?php

namespace Wl\Mvc\Result;

class ApiResult extends JsonResult
{
    const HTTP_CODE_BAD_REQUEST = 400;
    const HTTP_CODE_ACCESS_DENIED = 403;
    const HTTP_CODE_INTERNAL_SERVER_ERROR = 500;

    private function __construct($data, $code)
    {
        parent::__construct($data, $code);
        // restricted
    }

    public static function success($data = null, $code = 200)
    {
        return new self($data, $code);
    }

    public static function error($message = 'error', $data = null, $code = 400)
    {
        return new self([$message, $data], $code);
    }

    public static function errorAccessDenied($data = null)
    {
        return self::error('error_access_denied', $data, self::HTTP_CODE_ACCESS_DENIED);
    }

    public static function errorInternal($data = null)
    {
        return self::error('internal_server_error', $data, self::HTTP_CODE_INTERNAL_SERVER_ERROR);
    }
}