<?php

namespace App\Models\Messenger\Group;

use App\Models\Messenger\AbstractMessage;
use App\Models\Messenger\AbstractMessengerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends AbstractMessengerType
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'background',
        'personalization',
        'admin_id',
        'last_message_timestamp',
    ];

    protected function getUserInstance(): Model
    {
        return new GroupToUser();
    }

    protected function getMessageInstance(): AbstractMessage
    {
        return new GroupMessage();
    }
}
