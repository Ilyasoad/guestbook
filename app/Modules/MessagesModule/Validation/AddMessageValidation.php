<?php

namespace App\Modules\MessagesModule\Validation;

use App\Exceptions\AbstractAppException;
use App\Modules\LockModule\Interfaces\LockInterface;
use App\Modules\MessagesModule\Exceptions\LockMessageException;
use App\Modules\MessagesModule\Exceptions\MaxAllowedParentLevelException;
use App\Modules\MessagesModule\Exceptions\UndefinedMessageParentExceptions;
use App\Modules\MessagesModule\Interfaces\AddMessageRequestInterface;
use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Service\LevelCalculatorService;
use Ramsey\Uuid\UuidInterface;

/**
 * Class AddMessageValidation
 * Сервис валидации добавления нового сообщения
 *
 * @package App\Modules\MessagesModule\Validation
 */
class AddMessageValidation
{
    public const LOCK_KEY = 'addMessage';
    private const LOCK_TTL = 10;

    private const ALLOWED_PARENT_LEVEL = 2;

    /**
     * @var AddMessageRequestInterface
     */
    private $request;

    public function __construct(AddMessageRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @throws AbstractAppException
     */
    public function validate(): void
    {
        $this->trySetLock();
        $parentId = $this->request->getParentId();
        if ($parentId) {
            $this->checkAnswerLevel($parentId);
            $this->checkExistParent($parentId);
        }
    }

    /**
     * @throws LockMessageException
     */
    private function trySetLock(): void
    {
        $lockService = $this->getLockService();
        if (!$lockService->lock(self::LOCK_KEY, self::LOCK_TTL)) {
            throw new LockMessageException();
        }
    }

    /**
     * @param UuidInterface $parentId
     *
     * @throws MaxAllowedParentLevelException
     */
    private function checkAnswerLevel(UuidInterface $parentId): void
    {
        $parentLevel = $this->getLevelCalculatorService()->getLevelMessageId($parentId);

        if ($parentLevel > self::ALLOWED_PARENT_LEVEL) {
            throw new MaxAllowedParentLevelException();
        }
    }

    /**
     * @param UuidInterface $parentId
     *
     * @throws UndefinedMessageParentExceptions
     */
    private function checkExistParent(UuidInterface $parentId): void
    {
        $parentLevel = $this->getMessageRepository()->getMessageById($parentId);
        if (!$parentLevel) {
            throw new UndefinedMessageParentExceptions($parentId);
        }
    }

    private function getLockService(): LockInterface
    {
        return app(LockInterface::class);
    }

    private function getLevelCalculatorService(): LevelCalculatorService
    {
        return app(LevelCalculatorService::class);
    }

    private function getMessageRepository(): MessageRepositoryInterface
    {
        return app(MessageRepositoryInterface::class);
    }
}
