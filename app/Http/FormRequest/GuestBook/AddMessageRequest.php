<?php

namespace App\Http\FormRequest\GuestBook;

use App\Modules\MessagesModule\Interfaces\AddMessageRequestInterface;
use App\Modules\MessagesModule\Interfaces\MessageInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AddMessageRequest extends AbstractMessageRequest implements AddMessageRequestInterface
{
    protected const KEY_PARENT_UUID = MessageInterface::KEY_PARENT_UUID;

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            self::KEY_PARENT_UUID => ['nullable', 'string'],
        ]);
    }

    public function getParentId(): ?UuidInterface
    {
        $parentId = $this->get(self::KEY_PARENT_UUID);
        if (!$parentId) {
            return null;
        }

        return Uuid::fromString($parentId);
    }
}
