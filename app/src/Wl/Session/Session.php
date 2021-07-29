<?php

namespace Wl\Session;

class Session implements ISession
{
    public function getValue($key)
    {
        $this->assertSessionStarted();
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public function setValue($key, $value)
    {
        $this->assertSessionStarted();
        $_SESSION[$key] = $value;
    }

    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function stopSession()
    {
        $this->assertSessionStarted();
        session_write_close();
    }

    private function assertSessionStarted()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new \Exception("Session assertion failed, session is not active");
        }
    }
}