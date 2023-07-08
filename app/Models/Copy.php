<?php

namespace App\Models;

use App\Enums\CopyStatusEnum;
use Database\Factories\CopyFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Copy extends Model
{
    use HasFactory;

    protected static function newFactory(): CopyFactory
    {
        return CopyFactory::new();
    }

    /** @return Attribute<CopyStatusEnum, never> */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->users()->newPivotQuery()->where('due_date', '>', now())->exists()) {
                    return CopyStatusEnum::BORROWERD;
                }

                return CopyStatusEnum::AVAILABLE;
            }
        );
    }

    /** @return Attribute<string|null, never> */
    protected function currentBorrower(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->status === CopyStatusEnum::AVAILABLE) {
                    return null;
                }

                return $this->users()->getQuery()->latest('copy_user.created_at')->first('name')['name'];
            }
        );
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
