<?php

namespace App\Modules\MessagesModule\Interfaces;

/**
 * Запрос на изменение сообщения
 *
 * @package App\Modules\MessagesModule\Interfaces
 */
interface EditMessageRequestInterface
{
    public function getText(): string;

    public function getNick(): string;
}
