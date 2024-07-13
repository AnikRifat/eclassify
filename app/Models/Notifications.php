<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Notifications extends Model {
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'image',
        'item_id',
        'user_id',
        'send_to'
    ];


    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function getImageAttribute($value) {
        if (!empty($value)) {
            return url(Storage::url($value));
        }
        return "";
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('title', 'LIKE', $search)
                ->orWhere('message', 'LIKE', $search)
                ->orWhere('send_to', 'LIKE', $search)
                ->orWhere('item_id', 'LIKE', $search)
                ->orWhere('user_id', 'LIKE', $search)
                ->orWhere('created_at', 'LIKE', $search)
                ->orWhere('updated_at', 'LIKE', $search);
        });
        return $query;
    }

//    public function scopeSort($query, $column, $order) {
//        if ($column == "user_name") {
//            return $query->rightjoin('users', 'users.id', '=', 'notifications.user_id')->orderBy('users.name');
//        }
//        return $query->orderBy($column, $order);
//    }
}
