<?php

namespace App\Http\Resources;

use App\Modules\MessagesModule\Interfaces\MessageInterface;
use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MessageResource
 *
 * Структура для вывода сообщений в апи
 *
 * @package App\Http\Resources
 */
class MessageResource extends JsonResource
{
    /**
     * @var Message
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request): array
    {
        if (!($this->resource instanceof Message)) {
            return [];
        }

        $subMessages = array_map(function (Message $message) use ($request) {
            return (new self($message))->toArray($request);
        }, $this->getMessagesRepository()->getSubMessages($this->resource));

        $parentUuid = $this->resource->getParentUuid();

        return [
            MessageInterface::KEY_UUID => $this->resource->getUuid()->toString(),
            MessageInterface::KEY_NICK => $this->resource->getNick(),
            MessageInterface::KEY_TEXT => $this->resource->getText(),
            MessageInterface::KEY_PARENT_UUID => $parentUuid ? $parentUuid->toString() : null,
            MessageInterface::KEY_CREATED_AT => $this->resource->getCreatedAt()->getTimestamp(),
            MessageInterface::KEY_MESSAGES => $subMessages,
        ];
    }

    private function getMessagesRepository(): MessageRepositoryInterface
    {
        return app(MessageRepositoryInterface::class);
    }
}
