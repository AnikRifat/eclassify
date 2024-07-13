<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureSection extends Model {
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'sequence',
        'filter',
        'value',
        'style',
        'min_price',
        'max_price',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('title', 'LIKE', $search)
                ->orWhere('sequence', 'LIKE', $search)
                ->orWhere('filter', 'LIKE', $search)
                ->orWhere('value', 'LIKE', $search)
                ->orWhere('style', 'LIKE', $search)
                ->orWhere('min_price', 'LIKE', $search)
                ->orWhere('max_price', 'LIKE', $search)
                ->orWhere('created_at', 'LIKE', $search)
                ->orWhere('updated_at', 'LIKE', $search);
        });
        return $query;
    }
}
