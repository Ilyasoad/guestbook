<?php

namespace App\Modules\MessagesModule\Interfaces;

use App\Modules\MessagesModule\Models\Message;
use SimpleXMLElement;

interface MessageParserInterface
{
    /**
     * @param SimpleXMLElement $messages
     *
     * @return Message[]
     */
    public function parse(SimpleXMLElement $messages): array;
}
