<?php

namespace App\Http\Controllers;

use App\Exceptions\AbstractAppException;
use App\Http\FormRequest\GuestBook\AddMessageRequest;
use App\Http\FormRequest\GuestBook\EditMessageRequest;
use App\Http\Resources\MessageResource;
use App\Modules\MessagesModule\Interfaces\MessageRepositoryInterface;
use App\Modules\MessagesModule\Models\Message;
use App\Modules\MessagesModule\Service\AddMessageService;
use App\Modules\MessagesModule\Service\EditMessageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

class ApiGuestBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $messages = array_map(function (Message $message) {
            return new MessageResource($message);
        }, $this->getMessageRepository()->getParentMessages());

        return new JsonResponse($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddMessageRequest $messageRequest
     *
     * @return JsonResponse
     *
     * @throws AbstractAppException
     */
    public function store(AddMessageRequest $messageRequest): JsonResponse
    {
        $message = $this
            ->getAddMessageService()
            ->add($messageRequest);

        return new JsonResponse(
            new MessageResource($message)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $message = $this
            ->getMessageRepository()
            ->getMessageById(Uuid::fromString($id));

        if (!$message) {
            throw new ModelNotFoundException();
        }

        return new JsonResponse(
            new MessageResource($message)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditMessageRequest $request
     * @param  string  $id
     *
     * @return JsonResponse
     */
    public function update(EditMessageRequest $request, string $id): JsonResponse
    {
        $message = $this
            ->getEditMessageService()
            ->edit($request, Uuid::fromString($id));

          return new JsonResponse(
              new MessageResource($message)
          );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getAddMessageService(): AddMessageService
    {
        return app(AddMessageService::class);
    }

    private function getEditMessageService(): EditMessageService
    {
        return app(EditMessageService::class);
    }

    private function getMessageRepository(): MessageRepositoryInterface
    {
        return app(MessageRepositoryInterface::class);
    }
}
