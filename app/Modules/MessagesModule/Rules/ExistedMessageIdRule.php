<?php

namespace App\Modules\MessagesModule\Rules;

use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;
use Ramsey\Uuid\Uuid;

class ExistedMessageIdRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        $message = $this
            ->getMessageRepository()
            ->getMessageById(
                Uuid::fromString($value)
            );

        return $message !== null;
    }

    public function message()
    {
        return trans('validation.exists', ['attribute' => 'uuid']);
    }

    private function getMessageRepository(): MessageRepositoryInterface
    {
        return app(MessageRepositoryInterface::class);
    }
}
