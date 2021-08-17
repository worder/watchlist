<?php

namespace Wl\Http\HttpService;

use Wl\Http\Request\IRequest;
use Wl\Http\Request\Request;
use Wl\Utils\ParamStore\ParamsStore;

class HttpService implements IHttpService
{
    public function getRequest(): IRequest
    {
        $uri = $GLOBALS['_SERVER']['REQUEST_URI'];
        
        $uriParts = parse_url($uri);
        $getData = [];
        if (isset($uriParts['query'])) {
            parse_str($uriParts['query'], $getData);
        }

        $get = new ParamsStore($getData);
        $post = new ParamsStore($_POST);
        $cookies = new ParamsStore($_COOKIE);
        $files = new ParamsStore($_FILES);
        $headers = new ParamsStore([]);
        
        $method = $GLOBALS['_SERVER']['REQUEST_METHOD'];
        $path = $uri;

        return new Request($method, $path, null, '', $get, $post, $cookies, $files, $headers);
    }
}
