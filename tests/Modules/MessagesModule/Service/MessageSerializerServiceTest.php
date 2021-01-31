<?php

namespace Tests\Modules\MessagesModule\Service;

use App\Modules\MessagesModule\Models\Message;
use App\Modules\MessagesModule\Service\Store\MessageSerializerService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MessageSerializerServiceTest extends TestCase
{
    /**
     * @param Message[] $messages
     * @param string $expectedXML
     *
     * @dataProvider messageDataProvider
     */
    public function testToXml(array $messages, string $expectedXML)
    {
        $serializer = new \App\Modules\MessagesModule\Service\Store\MessageSerializerService();
        $res = $serializer->toXml($messages)->asXML();

        $this->assertEquals($this->toSimpleStr($res), $this->toSimpleStr($expectedXML));
    }

    private function toSimpleStr(string $string)
    {
        return preg_replace('/\s/um', '', $string);
    }

    public function messageDataProvider(): array
    {
        return [
            [[], '<?xml version="1.0"?><messages/>'],
            [
                [
                    $this->getMessage()
                        ->setUuid(Uuid::fromString('00000000-0000-0000-0000-000000000001')),
                    $this->getMessage()
                        ->setUuid(Uuid::fromString('00000000-0000-0000-0000-000000000002'))
                        ->setParentUuid(Uuid::fromString('00000000-0000-0000-0000-000000000001')),
                ],
             '<?xml version="1.0"?>
<messages>
    <message>
        <uuid>00000000-0000-0000-0000-000000000001</uuid>
        <nick>Nick name</nick>
        <text>Some text</text>
        <createdAt>2</createdAt>
        <parentUuid/>
    </message>
    <message>
        <uuid>00000000-0000-0000-0000-000000000002</uuid>
        <nick>Nick name</nick>
        <text>Some text</text>
        <createdAt>2</createdAt>
        <parentUuid>00000000-0000-0000-0000-000000000001</parentUuid>
    </message>
</messages>
']
        ];
    }

    //    private $uuid;
    //    private $nick;
    //    private $text;
    //    private $createdAt;
    //    private $parentUuid;

    private function getMessage(): Message
    {
        return (new Message())
            ->setNick('Nick name')
            ->setText('Some text')
            ->setCreatedAt(Carbon::createFromTimestamp(2));
    }
}
