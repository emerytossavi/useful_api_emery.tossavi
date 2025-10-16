<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    //
    protected $fillable = [
        "user_id",
        "original_url",
        'code',
        "clicks",
    ];

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }
}
