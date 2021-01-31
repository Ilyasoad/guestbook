<?php

namespace App\Modules\MessagesModule\Service\Store;

use App\Exceptions\AbstractAppException;
use App\Modules\MessagesModule\Exceptions\BadXmlMessagesStructureExceptions;
use App\Modules\MessagesModule\Interfaces\MessageInterface;
use App\Modules\MessagesModule\Interfaces\MessageParserInterface;
use App\Modules\MessagesModule\Models\Message;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use SimpleXMLElement;
use Throwable;

/**
 * Class MessageParserService
 *
 * Сервис, для получения сообщений, хранящихся в XML
 *
 * @package App\Modules\MessagesModule\Service\Store
 */
class MessageParserService implements MessageParserInterface
{
    /**
     * @param SimpleXMLElement $messages
     *
     * @return Message[]
     *
     * @throws AbstractAppException
     */
    public function parse(SimpleXMLElement $messages): array
    {
        $result = [];
        if ($messages->getName() !== MessageInterface::KEY_MESSAGES) {
            throw new BadXmlMessagesStructureExceptions();
        }

        foreach ($messages as $messageXml) {
            // тут можно было бы отлавливать каждое поле
            try {
                $result[] = $this->parseOneMessage($messageXml);
            } catch (Throwable $exception) {
                throw new BadXmlMessagesStructureExceptions();
            }
        }

        return $result;
    }

    /**
     * @param SimpleXMLElement $messageXml
     *
     * @return Message
     *
     * @throws BadXmlMessagesStructureExceptions
     */
    protected function parseOneMessage(SimpleXMLElement $messageXml): Message
    {
        if ($messageXml->getName() !== MessageInterface::KEY_MESSAGE) {
            throw new BadXmlMessagesStructureExceptions();
        }

        $message = new Message();
        #@todo add throw BadMessagesFieldExceptions
        $message->setText($messageXml->text);
        $message->setNick($messageXml->nick);
        $message->setUuid(Uuid::fromString($messageXml->uuid));

        $parentUuid = $messageXml->parentUuid->__toString();
        if ($parentUuid) {
            $message->setParentUuid(Uuid::fromString($messageXml->parentUuid));
        }

        $message->setCreatedAt(
            Carbon::createFromTimestamp((int) $messageXml->createdAt)
        );

        return $message;
    }
}
