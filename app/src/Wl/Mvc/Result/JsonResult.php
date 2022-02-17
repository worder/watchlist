<?php

namespace Wl\Mvc\Result;

class JsonResult implements IResult
{
    private $data;
    private $code;

    public function __construct($data, $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function toJson()
    {
        return json_encode($this->getData());
    }
}