<?php

namespace App\Modules\MessagesModule\Models;

use App\Modules\MessagesModule\Interfaces\MessageInterface;
use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

/**
 * Модель коментария
 *
 * @package App\Modules\MessagesModule\Models
 */
class Message implements MessageInterface
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @var string
     */
    private $nick;

    /**
     * @var string
     */
    private $text;

    /**
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var UuidInterface|null
     */
    private $parentUuid;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return Message
     */
    public function setUuid(UuidInterface $uuid): Message
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getNick(): string
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     *
     * @return Message
     */
    public function setNick(string $nick): Message
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Message
     */
    public function setText(string $text): Message
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param Carbon $createdAt
     *
     * @return Message
     */
    public function setCreatedAt(Carbon $createdAt): Message
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return UuidInterface|null
     */
    public function getParentUuid(): ?UuidInterface
    {
        return $this->parentUuid;
    }

    /**
     * @param UuidInterface|null $parentUuid
     *
     * @return Message
     */
    public function setParentUuid(?UuidInterface $parentUuid): Message
    {
        $this->parentUuid = $parentUuid;

        return $this;
    }
}
