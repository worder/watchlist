<?php

namespace Wl\HttpClient;

use Wl\HttpClient\Request\IRequest;

class HttpClient implements IHttpClient
{
    private $timeoutMs = 5000;
    private $connectionTimeoutMs = 3000;
    // private $retryAttempts = 2;
    // private $retryIntervalMs = 500;

    private $proxy;

    public function __construct()
    {
    }

    public function setTimeout($timeoutMs)
    {
        $this->timeoutMs = $timeoutMs;
    }

    public function setConnectionTimeout($timeoutMs)
    {
        $this->connectionTimeoutMs = $timeoutMs;
    }

    public function setRetryAttempts($attempts)
    {
        $this->retryAttempts = $attempts;
    }

    public function setRetryInterval($intervalMs)
    {
        $this->retryIntervalMs = $intervalMs;
    }

    public function setProxy(Proxy $proxy)
    {
        $this->proxy = $proxy;
        if (!$this->proxy->getType()) {
            throw new \Exception('Invalid proxy type: ' . $proxy->getType());
        }
        if (!$this->proxy->getProxy()) {
            throw new \Exception('Invalid proxy host: ' . $proxy->getProxy());
        }
    }

    public function dispatch(IRequest $request): Result
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->connectionTimeoutMs);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $this->timeoutMs);
        curl_setopt($ch, CURLOPT_HEADER, 1); // include to result
        curl_setopt($ch, CURLINFO_HEADER_OUT, true); // allow access to request headers
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        if ($this->proxy) {
            $type = $this->proxy->getType();
            switch($type) {
                case Proxy::TYPE_SOCKS5:
                    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                    break;
                case Proxy::TYPE_SOCKS4:
                    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
                    break;
                case Proxy::TYPE_HTTP:
                    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
                    break;
            }
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy->getProxy());
        }
        
        if ($request->getMethod() === IRequest::METHOD_POST) {
            curl_setopt($ch, CURLOPT_POST, 1);
            $postfields = $request->getParams();
            if (!empty($postfields)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
            }
        }
        $headers = $request->getHeaders();
        if (!empty($headers)) {
            $curlHeaders = [];
            foreach ($headers as $header => $value) {
                $curlHeaders[] = "{$header}: {$value}";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);
        }

        $response = curl_exec($ch);
        if ($response === false) {
            throw new HttpRequestException(curl_error($ch));
        }

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers_sent = curl_getinfo($ch, CURLINFO_HEADER_OUT);      
        
        $result = [];
        $result['header'] = substr($response, 0, $header_size);
        $result['body'] = substr($response, $header_size);
        $result['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result['last_url'] = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        return new Result($result['http_code'], $result['last_url'], $result['header'], $result['body'], $headers_sent);
    }
}
