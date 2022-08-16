<?php

namespace App\Models\Messenger;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'threadable_id',
        'threadable_type',
        'user_id',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
