<?php

namespace Wl\Http\Request;

use Wl\Utils\ParamStore\IParamStore;
use Wl\Utils\ParamStore\ParamsStore;

class Request implements IRequest
{
    private $method;
    private $path;
    private $protocol;
    private $get;
    private $post;
    private $cookies;
    private $files;
    private $headers;
    private $body;

    public function __construct(
        $method,
        $path,
        $protocol,
        $body,
        IParamStore $get,
        IParamStore $post,
        IParamStore $cookies,
        IParamStore $files,
        IParamStore $headers
    ) {
        $this->method = $method;
        $this->path = $path;
        $this->protocol = $protocol;
        $this->get = $get;
        $this->post = $post;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function method()
    {
        return $this->method;
    }

    public function path()
    {
        return $this->path;
    }

    public function protocol()
    {
        return $this->protocol;
    }

    public function get(): IParamStore
    {
        return $this->get;
    }

    public function post(): IParamStore
    {
        return $this->post;
    }

    public function cookies(): IParamStore
    {
        return $this->cookies;
    }

    public function files(): IParamStore
    {
        return $this->files;
    }

    public function headers(): IParamStore
    {
        return $this->headers;
    }

    public function body()
    {
        return $this->body;
    }
}
