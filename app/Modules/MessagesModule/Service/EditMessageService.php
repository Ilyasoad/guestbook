<?php

namespace App\Modules\MessagesModule\Service;

use App\Modules\MessagesModule\Events\EditMessageEvent;
use App\Modules\MessagesModule\Interfaces\EditMessageRequestInterface;
use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Models\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\UuidInterface;

/**
 * Class EditMessageService
 *
 * Обновление старого сообщения
 *
 * @package App\Modules\MessagesModule\Service
 */
class EditMessageService
{
    /**
     * @param EditMessageRequestInterface $editMessageRequest
     * @param UuidInterface $uuid
     *
     * @return ?Message
     */
    public function edit(EditMessageRequestInterface $editMessageRequest, UuidInterface $uuid): ?Message
    {
        $old = $this->getMessageRepository()->getMessageById($uuid);
        if (!$old) {
            throw new ModelNotFoundException();
        }

        $new = $this->fillModel($editMessageRequest, $old);
        $saveResult = $this->getMessageRepository()->saveMessage($new);

        if ($saveResult) {
            event(new EditMessageEvent($old, $new));
        }

        return $saveResult
            ? $new
            : $old;
    }

    private function fillModel(EditMessageRequestInterface $messageRequest, Message $old): Message
    {
        $new = clone $old;
        $new->setNick($messageRequest->getNick());
        $new->setText($messageRequest->getText());

        return $new;
    }

    private function getMessageRepository(): MessageRepositoryInterface
    {
        return app(MessageRepositoryInterface::class);
    }
}
