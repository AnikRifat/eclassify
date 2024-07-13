<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Package extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discount_in_percentage',
        'final_price',
        'duration',
        'item_limit',
        'type',
        'icon',
        'description',
        'status',
        'ios_product_id'
    ];

    public function user_purchased_packages() {
        return $this->hasMany(UserPurchasedPackage::class);
    }

    public function getIconAttribute($icon) {
        if (!empty($icon)) {
            return url(Storage::url($icon));
        }
        return $icon;
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('name', 'LIKE', $search)
                ->orWhere('price', 'LIKE', $search)
                ->orWhere('discount_in_percentage', 'LIKE', $search)
                ->orWhere('final_price', 'LIKE', $search)
                ->orWhere('duration', 'LIKE', $search)
                ->orWhere('item_limit', 'LIKE', $search)
                ->orWhere('type', 'LIKE', $search)
                ->orWhere('description', 'LIKE', $search)
                ->orWhere('status', 'LIKE', $search)
                ->orWhere('created_at', 'LIKE', $search)
                ->orWhere('updated_at', 'LIKE', $search);
        });
        return $query;
    }
}
