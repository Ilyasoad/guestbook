<?php

namespace App\Modules\MessagesModule\Repositories;

use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Interfaces\XmlStoreInterface;
use App\Modules\MessagesModule\Models\Message;
use Ramsey\Uuid\UuidInterface;

class XmlMessageRepository implements MessageRepositoryInterface
{
    /**
     * @var XmlStoreInterface
     */
    private $store;

    public function __construct(XmlStoreInterface $messageStore)
    {
        $this->store = $messageStore;
    }

    public function __destruct()
    {
        $this->store->saveMessages();
    }

    public function getMessageById(UuidInterface $uuid): ?Message
    {
        return $this->store
            ->getMessages()
            ->first(function (Message $message) use ($uuid) {
                return $message->getUuid()->toString() === $uuid->toString();
            });
    }

    public function getSubMessages(Message $message): array
    {
        $messageId = $message->getUuid()->toString();

        return $this->store
            ->getMessages()
            ->filter(function (Message $message) use ($messageId) {
                $parentId = $message->getParentUuid();
                if ($parentId === null) {
                    return false;
                }

                return $messageId === $parentId->toString();
            })
            ->all();
    }

    public function getParentMessages(): array
    {
        return $this->store
            ->getMessages()
            ->filter(function (Message $message) {
                return $message->getParentUuid() === null;
            })
            ->all();
    }

    public function saveMessage(Message $message): bool
    {
        return $this->store->saveMessage($message);
    }

    public function getAllMessages(): array
    {
        return $this->store->getMessages()->all();
    }
}
