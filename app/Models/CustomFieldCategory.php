<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static upsert(null[] $array, array $customFieldCategory)
 */
class CustomFieldCategory extends Model {
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'category_id',
        'custom_field_id'
    ];

    public function custom_fields() {
        return $this->hasOne(CustomField::class, 'id', 'custom_field_id');
    }

    public function category() {
        return $this->hasOne(Category::class);
    }
}
