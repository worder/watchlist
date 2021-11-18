<?php

namespace Wl\Mvc;

class Response
{
    private $body;
    private $code;

    public function __construct($body, $code = 200)
    {
        $this->body = $body;
        $this->code = $code;
    }

    public function render()
    {
        http_response_code($this->code);
        echo $this->body;
    }
}