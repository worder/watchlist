<?php

namespace Wl\Session;

interface ISession
{
    public function startSession();
    public function stopSession();
    public function getValue($key);
    public function setValue($key, $value);
}