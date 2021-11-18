<?php

namespace Wl\Controller;

class IndexController
{
    public function get()
    {
        require './front/index.html';
        exit();
    }
}