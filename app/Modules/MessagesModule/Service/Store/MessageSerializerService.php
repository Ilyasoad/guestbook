<?php

namespace App\Modules\MessagesModule\Service\Store;

use App\Modules\MessagesModule\Interfaces\MessageInterface;
use App\Modules\MessagesModule\Interfaces\MessageSerializerInterface;
use App\Modules\MessagesModule\Interfaces\XmlStoreInterface;
use App\Modules\MessagesModule\Models\Message;
use SimpleXMLElement;

/**
 * Class MessageSerializerService
 *
 * Сервис, для сохранения сообщений в XML
 *
 * @package App\Modules\MessagesModule\Service\Store
 */
class MessageSerializerService implements MessageSerializerInterface
{
    /**
     * @param Message[] $messages
     *
     * @return SimpleXMLElement
     */
    public function toXml(array $messages): SimpleXMLElement
    {
        $xml = new SimpleXMLElement(XmlStoreInterface::DEFAULT_STRUCTURE);
        foreach ($messages as $message) {
            $this->parseOneMessage($message, $xml);
        }

        return $xml;
    }

    protected function parseOneMessage(Message $message, SimpleXMLElement $xml): void
    {
        $msgXml = $xml->addChild(MessageInterface::KEY_MESSAGE);
        $msgXml->addChild(MessageInterface::KEY_UUID, $message->getUuid()->toString());
        $msgXml->addChild(MessageInterface::KEY_NICK, $message->getNick());
        $msgXml->addChild(MessageInterface::KEY_TEXT, $message->getText());
        $msgXml->addChild(MessageInterface::KEY_CREATED_AT, $message->getCreatedAt()->getTimestamp());
        $parentUuid = $message->getParentUuid();
        $msgXml->addChild(MessageInterface::KEY_PARENT_UUID, $parentUuid ? $parentUuid->toString() : null);
    }
}
