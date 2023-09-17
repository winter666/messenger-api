<?php


namespace App\Repositories;


use App\Models\Messenger\Chat\Chat;
use App\Models\User;

class UserRepository
{
    public function getInfo(int $id): User
    {
        /**
         * @var User $user
         */
        $user = User::query()->with([
            'chats', 'chats.users',
            'chats.messages', 'chats.messages.user'
        ])->findOrFail($id);

        $chats = $user->chats->filter(function(Chat $chat) use ($user) {
            if (!empty($chat->personalization) && !empty($chat->personalization[$user->id])) {
                return !$chat->personalization[$user->id]['hidden'];
            }

            return true;
        });

        $user->chats = $chats;

        return $user;
    }
}
