<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ISBN',
    ];

    public function newFactory(): BookFactory
    {
        return BookFactory::new();
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class);
    }
}
