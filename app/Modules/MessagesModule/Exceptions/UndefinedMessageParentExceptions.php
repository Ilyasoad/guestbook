<?php

namespace App\Modules\MessagesModule\Exceptions;

use App\Exceptions\AbstractAppException;
use Ramsey\Uuid\UuidInterface;

class UndefinedMessageParentExceptions extends AbstractAppException
{
    public function __construct(UuidInterface $uuid)
    {
        parent::__construct(trans('exceptions.badParent', ['parentUuid' => $uuid]));
    }
}
