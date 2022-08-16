<?php

namespace App\Models\Messenger\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatToUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['user_id', 'chat_id'];
}
