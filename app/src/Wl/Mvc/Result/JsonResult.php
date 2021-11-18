<?php

namespace Wl\Mvc\Result;

class JsonResult implements IResult
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function toJson()
    {
        return json_encode($this->getData());
    }
}