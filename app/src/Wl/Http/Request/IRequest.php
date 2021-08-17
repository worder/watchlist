<?php

namespace Wl\Http\Request;

use Wl\Utils\ParamStore\IParamStore;

interface IRequest
{
    public function method();
    public function path();
    public function protocol();
    public function get(): IParamStore;
    public function post(): IParamStore;
    public function cookies(): IParamStore;
    public function files(): IParamStore;
    public function headers(): IParamStore;
    public function body();
}