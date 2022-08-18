<?php


namespace App\Services\Messenger\Chat;


use App\DTO\Messenger\ChatDTO;
use App\Models\Messenger\Chat\Chat;
use App\Repositories\Messenger\ChatRepository;

class MakeChatService
{
    protected Chat $chat;
    protected ChatDTO $dto;
    protected ChatRepository $repository;

    public function __construct(array $data)
    {
        $this->dto = new ChatDTO($data);
        $this->repository = new ChatRepository();
    }

    public function run(): static
    {
        $this->chat = $this->repository->make($this->dto);
        return $this;
    }

    public function attachUsers(...$userIds): static
    {
        $this->repository->attachUsers($this->chat, ...$userIds);
        return $this;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }
}
