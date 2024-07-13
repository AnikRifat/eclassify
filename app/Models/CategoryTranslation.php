<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model {
    protected $fillable = [
        'name',
        'language_id',
        'category_id'
    ];

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
