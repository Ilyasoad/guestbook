<?php

namespace App\Modules\MessagesModule\Events;

use App\Modules\MessagesModule\Models\Message;

/**
 * Class EditMessageEvent
 * Событие изменения сообщения
 *
 * @package App\Modules\MessagesModule\Events
 */
class EditMessageEvent
{
    /**
     * @var Message
     */
    private $old;

    /**
     * @var Message
     */
    private $new;

    public function __construct(Message $old, Message $new)
    {
        $this->old = $old;
        $this->new = $new;
    }
}
