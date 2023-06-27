<?php

namespace App\Models;

use Database\Factories\CopyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    use HasFactory;

    public function newFactory(): CopyFactory
    {
        return CopyFactory::new();
    }
}