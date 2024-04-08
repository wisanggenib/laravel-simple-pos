<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CutOff extends Model
{
    use HasFactory;
    use HasUuids;
    public function areas(): HasOne
    {
        return $this->hasOne(Areas::class);
    }
}
