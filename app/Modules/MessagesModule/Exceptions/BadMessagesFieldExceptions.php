<?php

namespace App\Modules\MessagesModule\Exceptions;

use App\Exceptions\AbstractAppException;

class BadMessagesFieldExceptions extends AbstractAppException
{
    public function __construct(string $field)
    {
        parent::__construct(trans('exceptions.badXmlField', ['field' => $field]));
    }
}
