<?php

namespace Wl\Api\Search\Query;

class SearchQuery implements ISearchQuery
{
    private $term;
    private $page;
    private $limit;
    private $type;

    public function __construct($term = '', $type = null, $page = 1, $limit = 10)
    {
        $this->term = $term;
        $this->type = $type;
        $this->page = $page;
        $this->limit = $limit;
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
        $this->page = $page;
    }

    public function getMediaType()
    {
        return $this->type;
    }

    public function setMediaType($type)
    {
        $this->type = $type;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
}