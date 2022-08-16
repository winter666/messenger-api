<?php

namespace App\Models\Messenger\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'background',
        'personalization',
    ];

    protected $attributes = [
        'background' => '#fff',
        'personalization' => [
            'volume' => true,
        ]
    ];

    protected $casts = [
        'personalization' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, (new ChatToUser())->getTable());
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
