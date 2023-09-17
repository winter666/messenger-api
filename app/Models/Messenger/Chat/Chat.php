<?php

namespace App\Models\Messenger\Chat;

use App\Models\Messenger\AbstractMessage;
use App\Models\Messenger\AbstractMessengerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends AbstractMessengerType
{
    use HasFactory;

    protected $fillable = [
        'background',
        'personalization',
        'last_message_timestamp',
    ];

    protected $casts = [
        'personalization' => 'array',
    ];

    protected function getUserInstance(): Model
    {
        return new ChatToUser();
    }

    protected function getMessageInstance(): AbstractMessage
    {
        return new ChatMessage();
    }
}
