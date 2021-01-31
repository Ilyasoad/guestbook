<?php

namespace App\Modules\MessagesModule\Exceptions;

use App\Exceptions\AbstractAppException;

/**
 * Слишком быстро пришло новое сообщение
 *
 * @package App\Modules\MessagesModule\Exceptions
 */
class LockMessageException extends AbstractAppException
{

}
