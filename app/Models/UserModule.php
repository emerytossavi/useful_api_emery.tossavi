<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserModule extends Model
{
    //

    protected $fillable = [
        "user_id",
        "module_id",
        "active",
    ];

    public function User(){
        return $this->belongsTo("user_id");
    }

    public function Module(){
        return $this->belongsTo("module_id");
    }
}
