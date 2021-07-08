<?php

namespace Wl\HttpClient;

class Result 
{
    private $httpCode;
    private $headersStr;
    private $requestHeadersStr;
    private $body;
    private $url;



    public function __construct($httpCode, $url, $headersStr, $body, $requestHeadersStr)
    {
        $this->httpCode = $httpCode;
        $this->url = $url;
        $this->body = $body;
        $this->headersStr = $headersStr;
        $this->requestHeadersStr = $requestHeadersStr;
    }

    private function parseHeaders($headersStr)
    {
        preg_match_all('/([^:\s]+):\s*(.+)\s/', $headersStr, $m);
        $headers = [];
        for ($i = 0; $i < count($m[1]); $i++) {
            $headers[$m[1][$i]] = $m[2][$i];
        }
        return $headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->parseHeaders($this->headersStr);
    }

    public function getRequestHeaders()
    {
        return $this->parseHeaders($this->requestHeadersStr);
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getUrl()
    {
        return $this->url;
    }

}