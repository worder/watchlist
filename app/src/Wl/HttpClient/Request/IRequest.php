<?php

namespace Wl\HttpClient\Request;

interface IRequest
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public function getMethod();
    public function getUrl();
    public function getHeaders();
    public function getParams();
}