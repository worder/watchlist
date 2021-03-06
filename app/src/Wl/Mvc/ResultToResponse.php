<?php

namespace Wl\Mvc;

use Wl\Mvc\Exception\ControllerException;
use Wl\Mvc\Result\ErrorResult;
use Wl\Mvc\Result\IResult;
use Wl\Mvc\Result\JsonResult;

class ResultToResponse 
{
    public function getResponse($result): Response
    {
        $body = '';
        $code = 200;
        if ($result instanceof JsonResult) {
            $code = $result->getCode();
            $body = json_encode($result->getData());
        } elseif ($result instanceof IResult) {
            $code = $result->getCode();
            $body = $result->getData();
        } elseif ($result instanceof ControllerException) {
            $code = 400;
            $body = $result->getMessage();
        }

        return new Response($body, $code);
    }
}