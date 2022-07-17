<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    const CLOSED = 0;
    const OPEN = 1;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param $query
     * @return void
     */
    public function scopeOnlyOpen($query)
    {
        $query->where('status', self::OPEN);
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return (int)$this->status === Post::CLOSED;
    }
}
