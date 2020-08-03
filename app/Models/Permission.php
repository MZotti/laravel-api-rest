<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as TraitAuditable;

class Permission extends Model
{
    use SoftDeletes;

    const TOKEN_API = "ApiApp";

    protected $fillable = [
        "name", "guard_name", "created_at",
        "updated_at", "deleted_at",
    ];
}
