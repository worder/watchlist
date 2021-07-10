<?php

namespace Wl\Api\Search\Query;

interface ISearchQuery
{
    public function getMediaType();
    public function getTerm();
    public function getPage();
    public function getLimit();
}