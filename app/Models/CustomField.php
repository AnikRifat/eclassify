<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CustomField extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'image',
        'required',
        'status',
        'values',
        'min_length',
        'max_length',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    protected $append = ['value'];

    public function custom_field_category() {
        return $this->hasMany(CustomFieldCategory::class, 'custom_field_id');
    }

    public function item_custom_field_values() {
        return $this->hasMany(ItemCustomFieldValue::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, CustomFieldCategory::class);
    }

    public function getValuesAttribute($value) {
        try {
            return array_values(json_decode($value, true, 512, JSON_THROW_ON_ERROR));
        } catch (Throwable) {
            return $value;
        }
    }

    public function getImageAttribute($image) {
        if (!empty($image)) {
            return url(Storage::url($image));
        }
        return $image;
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('name', 'LIKE', $search)
                ->orWhere('type', 'LIKE', $search)
                ->orWhere('values', 'LIKE', $search)
                ->orWhere('status', 'LIKE', $search)
                ->orWhereHas('categories', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                });
        });
        return $query;
    }

    public function scopeFilter($query, $filterObject) {
        if (!empty($filterObject)) {
            foreach ($filterObject as $column => $value) {
                if ($column == "category_names") {
                    $query->whereHas('custom_field_category', function ($query) use ($value) {
                        $query->where('category_id', $value);
                    });
                } else {
                    $query->where((string)$column, (string)$value);
                }
            }
        }
        return $query;

    }
}
