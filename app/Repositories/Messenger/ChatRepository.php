<?php


namespace App\Repositories\Messenger;

use App\DTO\Messenger\AbstractMessengerTypeDTO;
use App\Models\Messenger\Chat\Chat;

class ChatRepository extends AbstractMessengerRepository
{
    public function make(AbstractMessengerTypeDTO $messengerDTO): Chat
    {
        /**
         * @var Chat $chat
         */
        $chat = Chat::query()->create($messengerDTO->toArray());
        return $chat;
    }


    public function getOne($id)
    {
        /**
         * @var Chat $chat
         */
        $chat = Chat::query()
            ->with(['users', 'messages', 'messages.user'])
            ->findOrFail($id);

        return $chat;
    }
}
