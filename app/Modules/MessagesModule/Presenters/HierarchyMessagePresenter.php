<?php

namespace App\Modules\MessagesModule\Presenters;

use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Models\Message;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class HierarchyMessagePresenter
 *
 * Структура, которая умеет выводить сообщения иерархично
 *
 * @package App\Modules\MessagesModule\Presenters]
 */
class HierarchyMessagePresenter extends MessagePresenter
{
    public function getSubMessages(): Arrayable
    {
        $subMessages = $this->getRepository()->getSubMessages($this->model);

        return collect($subMessages)
            ->map(function (Message $message) {
                return new self($message);
            });
    }

    private function getRepository(): MessageRepositoryInterface
    {
        return app(MessageRepositoryInterface::class);
    }
}
