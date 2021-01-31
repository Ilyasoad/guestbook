<?php

namespace App\Http\FormRequest\GuestBook;

use App\Http\FormRequest\AbstractRequest;
use App\Modules\MessagesModule\Interfaces\MessageInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractMessageRequest extends AbstractRequest
{
    protected const KEY_NICK = MessageInterface::KEY_NICK;
    protected const KEY_TEXT = MessageInterface::KEY_TEXT;

    public function rules(): array
    {
        return [
            self::KEY_NICK => ['required', 'string'],
            self::KEY_TEXT => ['required', 'string'],
        ];
    }

    public function getText(): string
    {
        return $this->get(self::KEY_TEXT);
    }

    public function getNick(): string
    {
        return $this->get(self::KEY_NICK);
    }
}
