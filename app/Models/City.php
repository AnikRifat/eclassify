<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model {
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "state_id",
        "state_code",
        "country_id",
        "country_code",
        "latitude",
        "longitude",
        "created_at",
        "updated_at",
        "flag",
        "wikiDataId",
    ];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";

        $query = $query->where(function ($q) use ($search) {
            $q->orWhere('id', 'LIKE', $search)
                ->orWhere('name', 'LIKE', $search)
                ->orWhere('state_id', 'LIKE', $search)
                ->orWhere('state_code', 'LIKE', $search)
                ->orWhere('country_id', 'LIKE', $search)
                ->orWhere('country_code', 'LIKE', $search)
                ->orWhereHas('state', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                })->orWhereHas('country', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                });
        });
        return $query;
    }

    public function scopeSort($query, $column, $order) {
        if ($column == "country_name") {
            $query = $query->leftjoin('countries', 'countries.id', '=', 'cities.country_id')->orderBy('countries.name', $order);
        } else if ($column == "state_name") {
            $query = $query->leftjoin('states', 'states.id', '=', 'cities.state_id')->orderBy('states.name', $order);
        } else {
            $query = $query->orderBy($column, $order);
        }

        return $query->select('cities.*');
    }
    public function scopeFilter($query, $filterObject) {
        if (!empty($filterObject)) {
            foreach ($filterObject as $column => $value) {
                if($column == "state_name") {
                    $query->whereHas('state', function ($query) use ($value) {
                        $query->where('state_id', $value);
                    });
                }
                elseif($column == "country_name") {
                    $query->whereHas('country', function ($query) use ($value) {
                        $query->where('country_id', $value);
                    });
                }
                else {
                    $query->where((string)$column, (string)$value);
                }
            }
        }
        return $query;

    }
}
