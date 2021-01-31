<?php

namespace App\Modules\MessagesModule\Service;

use App\Exceptions\AbstractAppException;
use App\Modules\MessagesModule\Events\NewMessageEvent;
use App\Modules\MessagesModule\Interfaces\AddMessageRequestInterface;
use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Models\Message;
use App\Modules\MessagesModule\Validation\AddMessageValidation;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Class AddMessageService
 *
 * Добавление нового сообщения
 *
 * @package App\Modules\MessagesModule\Service
 */
class AddMessageService
{
    /**
     * @param AddMessageRequestInterface $addMessageRequest
     *
     * @return Message
     *
     * @throws AbstractAppException
     */
    public function add(AddMessageRequestInterface $addMessageRequest): Message
    {
        (new AddMessageValidation($addMessageRequest))->validate();

        $message = $this->getMessageModel($addMessageRequest);
        $saveResult = $this->getMessageRepositoryInterface()->saveMessage($message);
        if ($saveResult) {
            event(new NewMessageEvent($message));
        }

        return $message;
    }

    private function getMessageModel(AddMessageRequestInterface $addMessageRequest): Message
    {
        $message = new Message();

        $message->setUuid(Uuid::uuid4());
        $message->setCreatedAt(Carbon::now());
        $message->setText($addMessageRequest->getText());
        $message->setNick($addMessageRequest->getNick());
        $message->setParentUuid($addMessageRequest->getParentId());

        return $message;
    }

    private function getMessageRepositoryInterface(): MessageRepositoryInterface
    {
        return app(MessageRepositoryInterface::class);
    }
}
