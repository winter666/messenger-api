<?php

namespace App\Models\Messenger\Chat;

use App\Models\Messenger\MessageThread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ChatMessage extends Model
{
    // TODO: сделать с Attacmentable (реляционно)
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chat_id',
        'content',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function threads(): MorphMany
    {
        return $this->morphMany(MessageThread::class, 'threadable');
    }
}
