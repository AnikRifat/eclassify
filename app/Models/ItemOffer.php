<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ItemOffer extends Model {
    use HasFactory;

    protected $fillable = [
        'item_id',
        'seller_id',
        'buyer_id',
        'amount'
    ];

    public function item() {
        return $this->belongsTo(Item::class)->withTrashed();
    }

    public function seller() {
        return $this->belongsTo(User::class);
    }

    public function buyer() {
        return $this->belongsTo(User::class);
    }

    public function scopeOwner($query) {
        return $query->where('seller_id', Auth::user()->id)->orWhere('buyer_id', Auth::user()->id);
    }
}
