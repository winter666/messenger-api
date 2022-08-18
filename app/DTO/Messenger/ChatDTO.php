<?php


namespace App\DTO\Messenger;


class ChatDTO extends AbstractMessengerTypeDTO
{
    protected function rules(): array
    {
        return [
            'background' => self::RULE_REQUIRED,
            'personalization' => self::RULE_NULLABLE,
        ];
    }
}
