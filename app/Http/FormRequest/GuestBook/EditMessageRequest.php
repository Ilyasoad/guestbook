<?php

namespace App\Http\FormRequest\GuestBook;

use App\Modules\MessagesModule\Interfaces\EditMessageRequestInterface;
use App\Modules\MessagesModule\Interfaces\MessageInterface;

class EditMessageRequest extends AbstractMessageRequest implements EditMessageRequestInterface
{
    private const KEY_UUID = MessageInterface::KEY_UUID;
}
