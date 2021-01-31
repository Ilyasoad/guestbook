<?php

namespace App\Modules\MessagesModule\Stores;

use App\Modules\MessagesModule\Interfaces\MessageParserInterface;
use App\Modules\MessagesModule\Interfaces\MessageSerializerInterface;
use App\Modules\MessagesModule\Interfaces\XmlStoreInterface;
use App\Modules\MessagesModule\Models\Message;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class XmlMessageStore implements XmlStoreInterface
{
    private const XML_PATH = 'message.xml';

    /**
     * @var MessageParserInterface
     */
    private $parser;

    /**
     * @var MessageSerializerInterface
     */
    private $serializer;

    /**
     * @var Collection|Message[]
     */
    private $messages;

    public function __construct(MessageParserInterface $parser, MessageSerializerInterface $serializer)
    {
        $this->parser = $parser;
        $this->serializer = $serializer;
    }

    public function getMessages(): Collection
    {
        if ($this->messages) {
            return $this->messages;
        }

        $xml = $this->getMessageXml();
        $messages = $this->parser->parse($xml);

        $this->messages = collect($messages)
            ->keyBy(function (Message $message) {
                return $message->getUuid();
            });

        return $this->messages;
    }

    public function saveMessages(): bool
    {
        $xml = $this->serializer
            ->toXml($this->getMessages()->all())
            ->saveXML($this->getMessagePath());

        return $xml !== false;
    }

    public function saveMessage(Message $message): bool
    {
        $messages = $this->getMessages();
        $messages->offsetSet($message->getUuid()->toString(), $message);

        $this->messages = $messages;

        return true;
    }

    private function getMessageXml(): SimpleXMLElement
    {
        $messagePath = $this->getMessagePath();
        if (!is_file($messagePath)) {
            return $this->getEmptySchema();
        }

        $xml = simplexml_load_file($messagePath);

        return $xml
            ? $xml
            : $this->getEmptySchema();
    }

    private function getMessagePath(): string
    {
        return storage_path(self::XML_PATH);
    }

    private function getEmptySchema(): SimpleXMLElement
    {
        return new SimpleXMLElement(self::DEFAULT_STRUCTURE);
    }
}
