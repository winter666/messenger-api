<?php


namespace App\Interfaces\Messenger;


use App\DTO\Messenger\AbstractMessageDTO;
use App\DTO\Messenger\AbstractMessengerTypeDTO;
use App\DTO\Messenger\MessageThreadDTO;
use App\Interfaces\ModelRepositoryInterface;
use App\Models\Messenger\AbstractMessage;
use App\Models\Messenger\AbstractMessengerType;
use App\Models\Messenger\MessageThread;

interface MessengerRepositoryInterface extends ModelRepositoryInterface
{
    public function make(AbstractMessengerTypeDTO $messengerDTO): AbstractMessengerType;

    public function changePersonalization(AbstractMessengerType $messenger, array $personalization): AbstractMessengerType;

    public function attachUsers(AbstractMessengerType $messenger, ...$user_ids);

    public function detachUsers(AbstractMessengerType $messenger, ...$user_ids);

    public function addMessageFromUser(AbstractMessengerType $messenger, $user_id, AbstractMessageDTO $messageDTO): AbstractMessage;

    public function sendOnThreadToMessage(AbstractMessage $message, $user_id, MessageThreadDTO $messageThreadDTO): MessageThread;
}
