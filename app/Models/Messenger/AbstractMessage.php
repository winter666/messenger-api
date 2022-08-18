<?php


namespace App\Models\Messenger;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

abstract class AbstractMessage extends Model
{
    use HasFactory;// TODO: сделать с Attacmentable (реляционно)

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function threads(): MorphMany
    {
        return $this->morphMany(MessageThread::class, 'threadable');
    }
}
