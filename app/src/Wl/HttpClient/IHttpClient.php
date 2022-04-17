<?php

namespace Wl\HttpClient;

use Wl\HttpClient\Request\IRequest;

interface IHttpClient 
{
    public function dispatch(IRequest $request): Result;
    public function setProxy(Proxy $proxy);
    public function setTimeout($timeoutMs);
    public function setConnectionTimeout($timeoutMs);
}