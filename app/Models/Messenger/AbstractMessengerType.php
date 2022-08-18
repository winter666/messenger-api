<?php


namespace App\Models\Messenger;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class AbstractMessengerType extends Model
{
    protected $casts = [
        'personalization' => 'array',
    ];

    abstract protected function getUserInstance(): Model;
    abstract protected function getMessageInstance(): AbstractMessage;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, $this->getUserInstance()->getTable());
    }

    public function messages(): HasMany
    {
        return $this->hasMany($this->getMessageInstance()::class);
    }
}
