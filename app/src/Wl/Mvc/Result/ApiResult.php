<?php

namespace Wl\Mvc\Result;

class ApiResult extends JsonResult
{
    private function __construct($data, $code)
    {
        parent::__construct($data, $code);
        // restricted
    }

    public static function success($data, $code = 200)
    {
        $json = [
            'data' => $data,
            'isError' => false,
            'error' => '',
        ];

        return new self($json, $code);
    }

    public static function error($data, $code = 400)
    {
        $json = [
            'data' => null,
            'isError' => true,
            'error' => $data,
        ];

        return new self($json, $code);
    }
}