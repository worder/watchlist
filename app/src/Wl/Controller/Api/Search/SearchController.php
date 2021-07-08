<?php

namespace Wl\Controller\Api\Search;

class SearchController 
{
    public function get($vars)
    {
        var_dump(
            'search: ' . $vars['term'],
        );
    }
}