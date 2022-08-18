<?php

namespace App\Models\Messenger\Chat;

use App\Models\Messenger\AbstractMessage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends AbstractMessage
{
    protected $fillable = [
        'user_id',
        'chat_id',
        'content',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
