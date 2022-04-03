<?php

namespace Wl\Mvc\Result;

class ApiResult extends JsonResult
{
    private function __construct($data, $code)
    {
        parent::__construct($data, $code);
        // restricted
    }

    public static function success($data = null, $code = 200)
    {
        $json = [
            'data' => $data,
        ];

        return new self($json, $code);
    }

    public static function error($error, $data = null, $code = 400)
    {
        $json = [
            'error' => $error,
            'data' => $data,
        ];

        return new self($json, $code);
    }
}