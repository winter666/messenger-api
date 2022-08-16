<?php

namespace Database\Seeders;

use App\Models\Messenger\Chat\Chat;
use App\Models\Messenger\Chat\ChatMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
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

        /**
         * @var Chat $chat
         */
        $chat = Chat::query()->create([
            'background' => '#fff',
            'personalization' => [ 'volume' => true ],
        ]);

        $chat->users()->sync([$firstUser->id, $secondUser->id]);

        /**
         * @var ChatMessage $firstMsg
         * @var ChatMessage $secMsg
         */
        $firstMsg = $chat->messages()->create([
           'user_id' => $firstUser->id,
           'content' => 'Hi!',
        ]);

        $secMsg = $chat->messages()->create([
           'user_id' => $firstUser->id,
           'content' => 'I\'ll sent your work on E-mail',
        ]);

        $firstMsg->threads()->create([
            'user_id' => $secondUser->id,
            'content' => 'Hi!',
        ]);

        $secMsg->threads()->create([
            'user_id' => $secondUser->id,
            'content' => 'Fine! Thanks:)',
        ]);

        $secMsg->threads()->create([
            'user_id' => $firstUser->id,
            'content' => 'Good luck!;)',
        ]);
    }
}
