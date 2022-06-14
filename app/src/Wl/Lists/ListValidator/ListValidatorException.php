<?php

namespace Wl\Lists\ListValidator;

use Exception;

class ListValidatorException extends Exception
{
    const TITLE_EMPTY = 'TITLE_EMPTY';
    const TITLE_LONG = 'TITLE_LONG';
    const INTERNAL_ERROR = 'INTERNAL_ERROR';
}
