<?php

namespace Wl\HttpClient\Request;

class Request implements IRequest
{
    private $method;
    private $url;
    private $params = [];
    private $headers = [];

    public function __construct($method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUrl()
    {
        if ($this->method === self::METHOD_GET) {
            if (stripos($this->url, '?') !== false) {
                $frags = parse_url($this->url);

                $parsedParams = [];
                foreach (explode('&', $frags['query']) as $chunk) {
                    $param = explode("=", $chunk);
                    if ($param) {
                        $parsedParams[$param[0]] = $param[1];
                    }
                }

                $mergedParams = array_merge($parsedParams, $this->params);

                return substr($this->url, 0, stripos($this->url, '?')) . '?' . http_build_query($mergedParams);
            } else {
                return $this->url . (!empty($this->params) ? ('?' . http_build_query($this->params)) : '');
            }
        }

        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function setParam($param, $value)
    {
        $this->params[$param] = $value;
        return $this;
    }

    public static function get($url, $params = [])
    {
        $r = new self(self::METHOD_GET);
        return $r->setUrl($url)->setParams($params);
    }

    public static function post($url, $params = [])
    {
        $r = new self(self::METHOD_POST);
        return $r->setUrl($url)->setParams($params);
    }
}
