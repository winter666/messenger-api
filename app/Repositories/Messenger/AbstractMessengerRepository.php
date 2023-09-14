<?php


namespace App\Repositories\Messenger;


use App\DTO\Messenger\AbstractMessageDTO;
use App\DTO\Messenger\MessageThreadDTO;
use App\Interfaces\Messenger\MessengerRepositoryInterface;
use App\Models\Messenger\AbstractMessage;
use App\Models\Messenger\AbstractMessengerType;
use App\Models\Messenger\MessageThread;

abstract class AbstractMessengerRepository implements MessengerRepositoryInterface
{
    public function attachUsers(AbstractMessengerType $messenger, ...$user_ids)
    {
        $messenger->users()->attach($user_ids);
    }

    public function detachUsers(AbstractMessengerType $messenger, ...$user_ids)
    {
        $messenger->users()->detach($user_ids);
    }

    public function addMessageFromUser(AbstractMessengerType $messenger, $user_id, AbstractMessageDTO $messageDTO): AbstractMessage
    {
        $forUpdatePersonalization = [];
        foreach ($messenger->personalization as $uId => $personalization) {
            $forUpdatePersonalization[$uId] = $personalization;
            $forUpdatePersonalization[$uId]['hidden'] = false;
        }

        $messenger->update(['personalization' => $forUpdatePersonalization]);

        /**
         * @var AbstractMessage $message
         */
        $message = $messenger->messages()
            ->create(array_merge($messageDTO->toArray(), [ 'user_id' => $user_id ]));

        return $message;
    }

    public function sendOnThreadToMessage(AbstractMessage $message, $user_id, MessageThreadDTO $messageThreadDTO): MessageThread
    {
        /**
         * @var MessageThread $threadMessage
         */
        $threadMessage = $message->threads()->create(array_merge(
            [ 'user_id' => $user_id ],
            $messageThreadDTO->toArray(),
        ));

        return $threadMessage;
    }

    public function changePersonalization(AbstractMessengerType $messenger, array $personalization): AbstractMessengerType
    {
        $messenger->update($personalization);
        return $messenger;
    }
}
