<?php

namespace Wl\Lists\ListValidator;

use Wl\Lists\IList;

class ListValidator
{
    public function validateListAdd(IList $list)
    {
        $title = $list->getTitle();
        if (empty($title)) {
            throw new ListValidatorException(ListValidatorException::TITLE_EMPTY);
        }

        if (strlen($title) > 256) {
            throw new ListValidatorException(ListValidatorException::TITLE_LONG);
        }
    }
}
