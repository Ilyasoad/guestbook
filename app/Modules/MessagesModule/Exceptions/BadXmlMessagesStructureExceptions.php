<?php

namespace App\Modules\MessagesModule\Exceptions;

use App\Exceptions\AbstractAppException;

/**
 * Не верная XML структура. попала в стор
 *
 * @package App\Modules\MessagesModule\Exceptions
 */
class BadXmlMessagesStructureExceptions extends AbstractAppException
{
    public function __construct()
    {
        parent::__construct(trans('exceptions.badXmlStructure'));
    }
}
