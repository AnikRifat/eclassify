<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model {
    use HasFactory;

    protected $fillable = [
        'firebase_id',
        'type',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
