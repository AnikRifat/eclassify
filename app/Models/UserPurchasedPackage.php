<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserPurchasedPackage extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'start_date',
        'end_date',
        'total_limit',
        'used_limit',
        'payment_transactions_id',
    ];

    protected $appends = ['remaining_days', 'remaining_item_limit'];

    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function PaymentTransaction() {
        return $this->belongsTo(PaymentTransaction::class);
    }

    public function scopeOnlyActive($query) {
        return $query->where('user_id', Auth::user()->id)->whereDate('start_date', '<=', date('Y-m-d'))->where(function ($q) {
            $q->whereDate('end_date', '>', date('Y-m-d'))->orWhereNull('end_date');
        })->where(function ($q) {
            $q->whereColumn('used_limit', '<', 'total_limit')->orWhereNull('total_limit');
        })->orderBy('end_date', 'asc');
    }

    public function getRemainingDaysAttribute() {
        if (!empty($this->end_date)) {
            $startDate = Carbon::createFromFormat('Y-m-d', $this->start_date);
            $endDate = Carbon::createFromFormat('Y-m-d', $this->end_date);
            return $startDate->diffInDays($endDate);
        }
        return "unlimited";
    }

    public function getRemainingItemLimitAttribute() {
        if (!empty($this->total_limit)) {
            return $this->total_limit - $this->used_limit;
        }
        return "unlimited";
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('user_id', 'LIKE', $search)
                ->orWhere('package_id', 'LIKE', $search)
                ->orWhere('start_date', 'LIKE', $search)
                ->orWhere('end_date', 'LIKE', $search)
                ->orWhere('total_limit', 'LIKE', $search)
                ->orWhere('used_limit', 'LIKE', $search)
                ->orWhere('created_at', 'LIKE', $search)
                ->orWhere('updated_at', 'LIKE', $search)
                ->orWhereHas('package', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                });
        });
        return $query;
    }
}
