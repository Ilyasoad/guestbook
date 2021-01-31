<?php

namespace App\Http\Controllers;

use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Models\Message;
use App\Modules\MessagesModule\Presenters\HierarchyMessagePresenter;

class GuestBookController extends Controller
{
    /**
     * @var MessageRepositoryInterface
     */
    private $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $messages = array_map(function (Message $message) {
            return new HierarchyMessagePresenter($message);
        }, $this->repository->getParentMessages());

        return view('guest-book.main')
            ->with(['messages' => $messages]);
    }
}
