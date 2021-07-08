<?php

namespace Wl\HttpClient;

use Wl\HttpClient\Request\IRequest;

interface IHttpClient 
{
    public function dispatch(IRequest $request): Result;
}