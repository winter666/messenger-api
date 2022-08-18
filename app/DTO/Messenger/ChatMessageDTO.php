<?php


namespace App\DTO\Messenger;


use App\DTO\BaseDTO;

class ChatMessageDTO extends AbstractMessageDTO
{

    protected function rules(): array
    {
        return [
            'content' => self::RULE_REQUIRED,
        ];
    }
}
