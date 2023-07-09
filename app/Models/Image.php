<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage', 'path', 'mime_type', 'size', 'imagable_id', 'imagable_type',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
