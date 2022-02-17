<?php

namespace Wl\Http\HttpService;

use Wl\Http\Request\IRequest;
use Wl\Http\Request\Request;
use Wl\Utils\ParamStore\ParamsStore;

class HttpService implements IHttpService
{
    public function request(): IRequest
    {
        $uri = $GLOBALS['_SERVER']['REQUEST_URI'];
        
        $uriParts = parse_url($uri);
        $getData = [];
        if (isset($uriParts['query'])) {
            parse_str($uriParts['query'], $getData);
        }

        $method = $GLOBALS['_SERVER']['REQUEST_METHOD'];
        $path = $uri;

        $get = new ParamsStore($getData);
        $post = new ParamsStore($_POST);
        $cookies = new ParamsStore($_COOKIE);
        $files = new ParamsStore($_FILES);
        $headers = new ParamsStore(getallheaders());

        if ($method === 'POST' && $headers->get('Content-Type') === 'application/json') {
            $json = file_get_contents('php://input');
            $post = new ParamsStore(json_decode($json, true));
        }
        

        return new Request($method, $path, null, '', $get, $post, $cookies, $files, $headers);
    }
}
