<?php


namespace App\DTO\Messenger;


use App\DTO\BaseDTO;

class MessageThreadDTO extends BaseDTO
{
    protected function rules(): array
    {
        return [
            'content' => self::RULE_REQUIRED,
            'created_at' => self::RULE_NULLABLE,
        ];
    }
}
