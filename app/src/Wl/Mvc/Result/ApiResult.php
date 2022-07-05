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

    public static function error($error, $data = null, $code = 400)
    {
        return new self([$error, $data], $code);
    }

    public static function accessDenied($data = null)
    {
        return new self($data, self::HTTP_CODE_ACCESS_DENIED);
    }
}