<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipTranslation extends Model {
    protected $fillable = [
        'description',
        'language_id',
        'tip_id'
    ];

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function tip() {
        return $this->belongsTo(Tip::class);
    }
}
