<?php

namespace App\Modules\MessagesModule\Events;

use App\Modules\MessagesModule\Models\Message;

/**
 * Class NewMessageEvent
 * Событие добавления нового сообщения,
 *
 * не отлавливается, потому что не нужно, хотя могло бы
 *
 * @package App\Modules\MessagesModule\Events
 */
class NewMessageEvent
{
    /**
     * @var Message
     */
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }
}
