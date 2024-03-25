<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Users extends Model implements AuthenticatableContract
{
    use HasFactory;
    use Authenticatable;
    use HasUuids;

    public function area(): BelongsTo
    {
        return $this->belongsTo(Areas::class, 'id_area', 'id');
    }
}
