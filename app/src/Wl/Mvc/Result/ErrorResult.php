<?php

namespace Wl\Mvc\Result;

class ErrorResult implements IResult
{
    private $errorData;
    private $httpCode;

    public function __construct($errorData, $httpCode = 200)
    {
        $this->errorData = $errorData;
        $this->httpCode = $httpCode;
    }

    public function getData()
    {
        return $this->errorData;
    }

    public function getCode()
    {
        return $this->httpCode;
    }
}