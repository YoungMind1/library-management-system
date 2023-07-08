<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ISBN',
    ];

    protected static function newFactory(): BookFactory
    {
        return BookFactory::new();
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imagable');
    }
}
