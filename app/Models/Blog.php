<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model {
    use HasFactory;

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'tags'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getImageAttribute($image) {
        if (!empty($image)) {
            return url(Storage::url($image));
        }
        return $image;
    }

    public function getTagsAttribute($value) {
        if (!empty($value)) {
            return explode(',', $value);
        }
        return $value;
    }

    public function setTagsAttribute($value) {
        return $this->attributes['tags'] = implode(',', $value);
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('title', 'LIKE', $search)
                ->orWhere('description', 'LIKE', $search)
                ->orWhere('tags', 'LIKE', $search);
        });
        return $query;
    }

    public function scopeSort($query, $column, $order) {
        if ($column == "category_name") {
            $query = $query->leftJoin('categories', 'categories.id', '=', 'blogs.category_id')->orderBy('categories.name', $order);
        } else {
            $query = $query->orderBy($column, $order);
        }
        return $query->select('blogs.*');
    }
}
