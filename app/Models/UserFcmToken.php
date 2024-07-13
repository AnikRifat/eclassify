<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFcmToken extends Model {
    use HasFactory;

    protected $fillable = [
        'fcm_token'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
