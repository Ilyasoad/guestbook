<?php

namespace App\Modules\MessagesModule\Interfaces;

use Ramsey\Uuid\UuidInterface;

/**
 * Запрос на добавление нового сообщения
 *
 * @package App\Modules\MessagesModule\Interfaces
 */
interface AddMessageRequestInterface
{
    public function getParentId(): ?UuidInterface;

    public function getText(): string;

    public function getNick(): string;
}
