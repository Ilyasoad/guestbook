<?php

namespace App\Modules\MessagesModule\Interfaces;

/**
 * Клю
 *
 * @package App\Modules\MessagesModule\Interfaces
 */
interface MessageInterface
{
    public const KEY_MESSAGES = 'messages';
    public const KEY_MESSAGE = 'message';

    public const KEY_UUID = 'uuid';
    public const KEY_NICK = 'nick';
    public const KEY_TEXT = 'text';
    public const KEY_CREATED_AT = 'createdAt';
    public const KEY_PARENT_UUID = 'parentUuid';
}
