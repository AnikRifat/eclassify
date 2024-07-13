<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Chat extends Model {
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'item_offer_id',
        'message',
        'file',
        'audio'
    ];
    protected $appends = ['message_type'];

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getFileAttribute($file) {
        if (!empty($file)) {
            return url(Storage::url($file));
        }
        return $file;
    }

    public function getAudioAttribute($value) {
        if (!empty($value)) {
            return url(Storage::url($value));
        }
        return $value;
    }

    public function getMessageTypeAttribute() {
        if (!empty($this->audio)) {
            return "audio";
        }

        if (!empty($this->file) && $this->message == "") {
            return "file";
        }

        if (!empty($this->file) && $this->message != "") {
            return "file_and_text";
        }

        return "text";
    }
}
