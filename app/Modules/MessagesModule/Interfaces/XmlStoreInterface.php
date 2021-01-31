<?php

namespace App\Modules\MessagesModule\Interfaces;

use App\Modules\MessagesModule\Models\Message;
use Illuminate\Support\Collection;

interface XmlStoreInterface
{
    public const DEFAULT_STRUCTURE = '<messages></messages>';

    public function getMessages(): Collection;

    public function saveMessages(): bool;

    public function saveMessage(Message $message): bool;
}
