<?php

namespace Wl\Lists\ListService;

use Wl\Lists\IList;

interface IListService 
{
    public function createList(IList $list): IList;
    public function getListById($id): ?IList;
}