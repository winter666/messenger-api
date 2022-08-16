<?php

namespace App\Models\Messenger\Group;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'background',
        'personalization',
        'admin_id',
    ];

    protected $casts = [
        'personalization' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, (new GroupToUser())->getTable());
    }

    public function messages(): HasMany
    {
        return $this->hasMany(GroupMessage::class);
    }
}
