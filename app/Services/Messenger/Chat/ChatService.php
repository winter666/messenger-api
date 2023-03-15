<?php


namespace App\Services\Messenger\Chat;


use App\DTO\Messenger\ChatMessageDTO;
use App\DTO\Messenger\MessageThreadDTO;
use App\Models\Messenger\Chat\Chat;
use App\Models\Messenger\Chat\ChatMessage;
use App\Repositories\Messenger\ChatRepository;

class ChatService
{
    protected Chat $chat;
    protected ChatRepository $repository;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
        $this->repository = new ChatRepository();
    }

    public function addUserMessage(int $userId, array $data)
    {
        $dto = new ChatMessageDTO($data);
        $this->repository->addMessageFromUser($this->chat, $userId, $dto);
    }

    public function addUserThreadMessage(int $messageId, int $userId, array $data)
    {
        /**
         * @var ChatMessage $message
         */
        $message = $this->chat->messages()->findOrFail($messageId);
        $dto = new MessageThreadDTO($data);
        $this->repository->sendOnThreadToMessage($message, $userId, $dto);
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function queryChat(): Chat
    {
        return Chat::query()
            ->with(['users', 'messages', 'messages.user'])
            ->findOrFail($this->chat->id);
    }
}
