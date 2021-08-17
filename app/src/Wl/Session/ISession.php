<?php

namespace Wl\Session;

interface ISession
{
    public function startSession();
    public function stopSession();
    public function get($key);
    public function set($key, $value);
}