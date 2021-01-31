<?php

namespace App\Modules\MessagesModule\Stores;

use App\Modules\MessagesModule\Interfaces\XmlStoreInterface;
use App\Modules\MessagesModule\Models\Message;
use Illuminate\Support\Collection;

/**
 * Class FakeStore
 *
 * Фейковый стор сообщений, для тестов.
 * Нужен, так как настоящем сторе идет обращение к файлам
 *
 * @package App\Modules\MessagesModule\Stores
 */
class FakeStore implements XmlStoreInterface
{
    /**
     * @var Collection|Message[]
     */
    private $messages;

    public function getMessages(): Collection
    {
        if ($this->messages) {
            return $this->messages;
        }

        return collect();
    }

    public function saveMessages(): bool
    {
        return true;
    }

    public function saveMessage(Message $message): bool
    {
        $messages = $this->getMessages();
        $messages->offsetSet($message->getUuid()->toString(), $message);

        $this->messages = $messages;

        return true;
    }
}
