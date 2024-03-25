<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Areas extends Model
{
    use HasFactory;
    use HasUuids;
    public function user(): HasMany
    {
        return $this->HasMany(Users::class);
    }
}
