<?php

namespace App\Models\Messenger\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupToUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'group_id'];
}
