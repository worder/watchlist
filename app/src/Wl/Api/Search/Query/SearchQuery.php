<?php

namespace Wl\Api\Search\Query;

class SearchQuery implements ISearchQuery
{
    private $term = null;
    private $page = 1;
    private $type;

    public function __construct()
    {

    }

    public function getTerm()
    {
        return $this->term;
    }

    public function setTerm($term)
    {
        $this->term = $term;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        return $this->page;
    }

    public function getMediaType()
    {
        return $this->type;
    }

    public function setMediaType($type)
    {
        $this->type = $type;
    }
}