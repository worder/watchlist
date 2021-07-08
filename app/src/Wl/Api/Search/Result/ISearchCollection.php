<?php

namespace Wl\Api\Search\Result;

interface ISearchCollection
{
    public function getPages();
    public function getPage();
    public function getCount();
    public function getItems();
}