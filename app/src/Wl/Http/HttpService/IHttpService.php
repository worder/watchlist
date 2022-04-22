<?php

namespace Wl\Http\HttpService;

use Wl\Http\Request\IRequest;

interface IHttpService
{
    public function request(): IRequest;
    public function redirect($url): void;
    public function header($name, $value): void;
}