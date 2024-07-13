<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Str;

class Setting extends Model {
    use HasFactory;

    public $table = "settings";

    protected $fillable = [
        'name',
        'value',
        'type'
    ];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function getValueAttribute($value) {
        if (isset($this->attributes['type']) && $this->attributes['type'] == "file") {

            if (!empty($value)) {
                /*Note : Because this is default logo so storage url will not work*/
                if (Str::contains($value,'assets')) {
                    return asset($value);
                }
                return url(Storage::url($value));
            }
            return "";
        }
        return $value;
    }
}
