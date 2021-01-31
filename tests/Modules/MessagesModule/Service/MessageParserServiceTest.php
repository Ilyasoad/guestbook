<?php

namespace Tests\Modules\MessagesModule\Service;

use App\Modules\MessagesModule\Service\Store\MessageParserService;
use App\Modules\MessagesModule\Stores\XmlMessageStore;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class MessageParserServiceTest extends TestCase
{
    public function testEmptyMessages()
    {
        $emptyMessages = new \SimpleXMLElement(XmlMessageStore::DEFAULT_STRUCTURE);
        $service = new MessageParserService();
        $result = $service->parse($emptyMessages);

        $this->assertEquals([], $result);
    }

    public function testParseMessagesGroup()
    {
        $xml = <<<XML
<messages>
    {$this->getRandomMessageXMLStr(true)}
    {$this->getRandomMessageXMLStr(false)}
    {$this->getRandomMessageXMLStr(true)}
    {$this->getRandomMessageXMLStr(false)}
    {$this->getRandomMessageXMLStr(false)}
    {$this->getRandomMessageXMLStr(true)}
</messages>
XML;
        $emptyMessages = new \SimpleXMLElement($xml);

        $service = new \App\Modules\MessagesModule\Service\Store\MessageParserService();
        $result = $service->parse($emptyMessages);

        $this->assertEquals(6, count($result));
    }

    public function testParseOneMessages()
    {
        $name = 'name';
        $text = 'text';
        $createdAt = 1000000;
        $uuid = 'fd0ffc90-f612-4eb7-8a18-713b8cc70c20';

        $xml = <<<XML
<messages>
    <message>
        <nick>{$name}</nick>
        <text>{$text}</text>
        <createdAt>{$createdAt}</createdAt>
        <uuid>{$uuid}</uuid>
        <parentUuid>{$uuid}</parentUuid>
    </message>
</messages>
XML;
        $emptyMessages = new \SimpleXMLElement($xml);

        $service = new MessageParserService();
        $messages = $service->parse($emptyMessages);
        $message = array_pop($messages);

        $this->assertEquals($message->getText(), $text);
        $this->assertEquals($message->getNick(), $name);
        $this->assertEquals($message->getCreatedAt()->getTimestamp(), $createdAt);
        $this->assertEquals($message->getUuid()->toString(), $uuid);
        $this->assertEquals($message->getParentUuid()->toString(), $uuid);
    }

    private function getRandomMessageXMLStr(bool $withParent): string
    {
        $faker = $this->getFaker();

        $message = '<message>';
        $message .= "<uuid>{$faker->uuid}</uuid>";
        $message .= "<nick>{$faker->name}</nick>";
        $message .= "<text>{$faker->text()}</text>";
        $message .= "<createdAt>{$faker->dateTime()->getTimestamp()}</createdAt>";
        if ($withParent) {
            $message .= "<parentUuid>{$faker->uuid}</parentUuid>";
        }
        $message .= '</message>';

        return $message;
    }

    private function getFaker(): Generator
    {
        return Factory::create();
    }
}
