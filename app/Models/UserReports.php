<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReports extends Model {
    use HasFactory;

    protected $fillable = [
        'id',
        'report_reason_id',
        'item_id',
        'user_id',
        'other_message',
        'reason'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function report_reason() {
        return $this->belongsTo(ReportReason::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('report_reason_id', 'LIKE', $search)
                ->orWhere('item_id', 'LIKE', $search)
                ->orWhere('user_id', 'LIKE', $search)
                ->orWhere('other_message', 'LIKE', $search)
                ->orWhere('reason', 'LIKE', $search)
                ->orWhere('created_at', 'LIKE', $search)
                ->orWhere('updated_at', 'LIKE', $search)
                ->orWhereHas('report_reason', function ($q) use ($search) {
                    $q->where('reason', 'LIKE', $search);
                })->orWhereHas('item', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                });
        });
        return $query;
    }

    public function scopeSort($query, $column, $order) {
        if ($column == "item_name") {
            $query = $query->leftjoin('items', 'items.id', '=', 'user_reports.item_id')->orderBy('items.name', $order);
        } else if ($column == "user_name") {
            $query = $query->leftjoin('users', 'users.id', '=', 'user_reports.user_id')->orderBy('users.name', $order);
        } else if ($column == "report_reason_name") {
            $query = $query->leftjoin('report_reasons', 'report_reasons.id', '=', 'user_reports.report_reason_id')->orderBy('report_reasons.reason', $order);
        } else {
            $query = $query->orderBy($column, $order);
        }

        return $query->select('user_reports.*');
    }

    public function scopeFilter($query, $filterObject) {
        if (!empty($filterObject)) {
            foreach ($filterObject as $column => $value) {
                $query->where((string)$column, (string)$value);
            }
        }
        return $query;

    }
    public function getStatusAttribute($value) {
        if ($this->deleted_at) {
            return "inactive";
        }

        return $value;
    }



}
