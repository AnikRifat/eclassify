<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tip extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description'
    ];
    protected $appends = ['translated_name'];

    public function translations() {
        return $this->hasMany(TipTranslation::class);
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        return $query->where(function ($q) use ($search) {
            $q->orWhere('description', 'LIKE', $search)
                ->orWhereHas('translations', function ($q) use ($search) {
                    $q->where('description', 'LIKE', $search);
                });
        });
    }

    public function getTranslatedNameAttribute() {
        $languageCode = request()->header('Content-Language');
        if (!empty($languageCode) && $this->relationLoaded('translations')) {
            // NOTE : This code can be done in Cache
            $language = Language::select(['id', 'code'])->where('code', $languageCode)->first();
            if (empty($language)) {
                return $this->description;
            }
            $translation = $this->translations->first(static function ($data) use ($language) {
                return $data->language_id == $language->id;
            });

            return $translation->description ?? $this->description;
        }

        return $this->description;
    }
}
