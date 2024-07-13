<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model {
    use HasFactory, HasRecursiveRelationships;

    protected $fillable = [
        'name',
        'parent_category_id',
        'image',
        'slug',
        'status',
        'description'
    ];

    public function getParentKeyName() {
        return 'parent_category_id';
    }

    protected $appends = ['translated_name'];

    public function subcategories() {
        return $this->hasMany(self::class, 'parent_category_id');
    }

    public function custom_fields() {
        return $this->hasMany(CustomFieldCategory::class);
    }

    public function getImageAttribute($image) {
        if (!empty($image)) {
            return url(Storage::url($image));
        }
        return $image;
    }

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function approved_items() {
        return $this->hasMany(Item::class)->where('status', 'approved');
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        return $query->where(function ($q) use ($search) {
            $q->orWhere('name', 'LIKE', $search)
                ->orWhere('description', 'LIKE', $search)
                ->orWhereHas('translations', function ($q) use ($search) {
                    $q->where('description', 'LIKE', $search);
                });
        });
    }

    public function slider(): MorphOne {
        return $this->morphOne(Slider::class, 'model');
    }

    public function translations() {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function getTranslatedNameAttribute() {
        $languageCode = request()->header('Content-Language');
        if (!empty($languageCode) && $this->relationLoaded('translations')) {
            // NOTE : This code can be done in Cache
            $language = Language::select(['id', 'code'])->where('code', $languageCode)->first();

            $translation = $this->translations->first(static function ($data) use ($language) {
                return $data->language_id == $language->id;
            });

            return $translation->name ?? $this->name;
        }

        return $this->name;
    }
}
