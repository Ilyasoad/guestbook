<?php

namespace App\Modules\MessagesModule\Interfaces;

use SimpleXMLElement;

interface MessageSerializerInterface
{
    public function toXml(array $messages): SimpleXMLElement;
}
