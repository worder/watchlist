<?php

namespace Wl\Controller\Api\Search;

use Wl\Http\HttpService\IHttpService;

class SearchController 
{

    /**
     * @Inject
     * @var IHttpService
     */
    private $https;

    public function get($vars)
    {
        var_dump($this->https->request()->get());
        var_dump($vars);
    }
}