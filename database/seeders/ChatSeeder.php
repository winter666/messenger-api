<?php

namespace Database\Seeders;

use App\Models\Messenger\Chat\ChatMessage;
use App\Models\User;
use App\Repositories\Messenger\ChatRepository;
use App\Services\Messenger\Chat\ChatService;
use App\Services\Messenger\Chat\MakeChatService;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param ChatRepository $repository
     * @return void
     */
    public function run()
    {
        /**
         * @var User $firstUser
         * @var User $secondUser
         */
        $firstUser = User::query()->first();
        $secondUser = User::query()->where('id', '!=', $firstUser->id)->first();

        $chatData = [
            'background' => '#3f3f3f',
            'personalization' => null,
        ];

        $chat = (new MakeChatService($chatData))
            ->run()
            ->attachUsers($firstUser->id, $secondUser->id)
            ->getChat();

        $chatService = new ChatService($chat);
        $chatService->addUserMessage($firstUser->id, ['content' => 'Hi, ' . $secondUser->name . '!']);
        $chatService->addUserMessage($firstUser->id, ['content' => 'I\'ll sent your work on E-mail']);

        // Warning: Hardcode
        $firstMsg = ChatMessage::query()->first();
        $secondMsg = ChatMessage::query()->orderByDesc('id')->first();
        // Warning: Hardcode

        $chatService->addUserThreadMessage($firstMsg->id, $secondUser->id, [
            'content' => 'Hi!',
            'created_at' => $firstMsg->created_at->addMinutes(2) // For the message created time
        ]);

        $chatService->addUserThreadMessage($secondMsg->id, $secondUser->id, [
            'content' => 'Fine! Thanks:)',
            'created_at' => $firstMsg->created_at->addMinutes(2) // For the message created time
        ]);

        $chatService->addUserThreadMessage($secondMsg->id, $firstUser->id, [
            'content' => 'Good luck!;)',
            'created_at' => $firstMsg->created_at->addMinutes(5) // For the message created time
        ]);
    }
}
