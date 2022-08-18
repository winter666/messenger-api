<?php

namespace App\Models\Messenger\Group;

use App\Models\Messenger\AbstractMessage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMessage extends AbstractMessage
{
    protected $fillable = [
        'user_id',
        'group_id',
        'content',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
