<?php

namespace App\Modules\MessagesModule\Presenters;

use App\Modules\MessagesModule\Models\Message;

class MessagePresenter
{
    protected $model;

    public function __construct(Message $model)
    {
        $this->model = $model;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    public function __get($name)
    {
        return $this->model->{$name};
    }
}
