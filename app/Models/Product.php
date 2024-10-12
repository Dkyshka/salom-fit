<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'video',
        'chat_id'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function chat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function picture(): Model|MorphMany|null
    {
        return $this->morphMany(Picture::class, 'imageable')->first();
    }

    public function pictures(): MorphMany
    {
        return $this->morphMany(Picture::class, 'imageable');
    }
}
