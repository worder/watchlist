<?php

namespace Wl\Http\HttpService;

use Wl\Http\Request\IRequest;

interface IHttpService
{
    public function request(): IRequest;

}