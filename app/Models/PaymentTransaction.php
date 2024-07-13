<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model {
    protected $fillable = [
        'user_id',
        'amount',
        'payment_gateway',
        'order_id',
        'payment_status',
        'created_at',
        'updated_at'
    ];
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        return $query->where(function ($q) use ($search) {
            $q->orWhere('id', 'LIKE', $search)
                ->orWhere('payment_gateway', 'LIKE', $search)
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                });
        });
    }
}
