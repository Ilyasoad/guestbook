<?php

namespace Tests\Modules\MessagesModule\Service;

use App\Modules\MessagesModule\Models\Message;
use App\Modules\MessagesModule\Service\LevelCalculatorService;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class LevelCalculatorServiceTest extends TestCase
{
    public function testGetLevelMessageId()
    {
        /** @var LevelCalculatorService|Mock $service */
        $service = Mockery::mock(LevelCalculatorService::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $uuid = Uuid::fromString('00000000-0000-0000-0000-000000000003');
        $parentUuid = Uuid::fromString('00000000-0000-0000-0000-000000000002');
        $grandParentUuid = Uuid::fromString('00000000-0000-0000-0000-000000000001');

        $message = (new Message())
            ->setParentUuid($parentUuid)
            ->setUuid($uuid);

        $parentMessage = (new Message())
                    ->setParentUuid($grandParentUuid)
                    ->setUuid($parentUuid);

        $grandParentMessage = (new Message())
            ->setUuid($parentUuid);

        $service
            ->shouldReceive('getMessageByUuid')
            ->times(1)
            ->andReturn($message);

        $service
            ->shouldReceive('getParentMessage')
            ->times(3)
            ->andReturn($parentMessage, $grandParentMessage, null);

        $this->assertEquals(3, $service->getLevelMessageId($uuid));
    }
}
