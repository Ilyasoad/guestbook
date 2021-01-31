<?php

namespace App\Modules\MessagesModule\Interfaces;

use App\Modules\MessagesModule\Models\Message;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface MessageRepositoryInterface
 *
 * Интерфес для репозитория сообщений
 *
 * @package App\Modules\MessagesModule\Interfaces
 */
interface MessageRepositoryInterface
{
    public function getMessageById(UuidInterface $uuid): ?Message;

    /**
     * @param Message $message
     *
     * @return Message[]
     */
    public function getSubMessages(Message $message): array;

    public function saveMessage(Message $message): bool;

    public function getAllMessages(): array;

    public function getParentMessages(): array;
}
