<?php

namespace App\Modules\MessagesModule\Exceptions;

use App\Exceptions\AbstractAppException;

/**
 * Привысили вложенность сообщения
 *
 * @package App\Modules\MessagesModule\Exceptions
 */
class MaxAllowedParentLevelException extends AbstractAppException
{

}
