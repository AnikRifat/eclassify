<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Language extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'name_in_english',
        'code',
        'app_file',
        'panel_file',
        'web_file',
        'rtl',
        'image'
    ];

    public function getRtlAttribute($rtl) {
        return $rtl != 0;
    }

    public function getImageAttribute($value) {
        if (!empty($value)) {
            if ($this->code == "en") {
                return asset("/assets/images/" . $value);
            }
            return url(Storage::url($value));
        }
        return "";
    }
}
