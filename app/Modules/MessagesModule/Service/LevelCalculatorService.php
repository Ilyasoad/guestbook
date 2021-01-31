<?php

namespace App\Modules\MessagesModule\Service;

use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Models\Message;
use Ramsey\Uuid\UuidInterface;

/**
 * Class LevelCalculatorService
 *
 * Сервис для подсчета уровня вложенности сообщений
 *
 * @package App\Modules\MessagesModule\Service
 */
class LevelCalculatorService
{
    /**
     * @var MessageRepositoryInterface
     */
    private $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getLevelMessageId(UuidInterface $uuid): ?int
    {
        $message = $this->getMessageByUuid($uuid);
        if ($message === null) {
            return null;
        }
        $level = 0;

        while ($message) {
            $message = $this->getParentMessage($message);
            $level++;
        }

        return $level;
    }

    protected function getMessageByUuid(UuidInterface $uuid): ?Message
    {
        return $this->repository->getMessageById($uuid);
    }

    protected function getParentMessage(Message $message): ?Message
    {
        $parentUuid = $message->getParentUuid();

        return $parentUuid
            ? $this->getMessageByUuid($parentUuid)
            : null;
    }
}
