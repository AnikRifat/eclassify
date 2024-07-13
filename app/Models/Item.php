<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Item extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'latitude',
        'longitude',
        'address',
        'contact',
        'show_only_to_premium',
        'video_link',
        'status',
        'rejected_reason',
        'user_id',
        'image',
        'country',
        'state',
        'city',
        'area_id',
        'all_category_ids',
        'slug'
    ];

    // Relationships
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function gallery_images() {
        return $this->hasMany(ItemImages::class);
    }

    public function custom_fields() {
        return $this->hasManyThrough(
            CustomField::class, CustomFieldCategory::class,
            'category_id', 'id', 'category_id', 'custom_field_id'
        );
    }

    public function item_custom_field_values() {
        return $this->hasMany(ItemCustomFieldValue::class);
    }

    public function featured_items() {
        return $this->hasMany(FeaturedItems::class)->onlyActive();
    }

    public function favourites() {
        return $this->hasMany(Favourite::class);
    }

    public function item_offers() {
        return $this->hasMany(ItemOffer::class);
    }

    public function user_reports() {
        return $this->hasMany(UserReports::class);
    }

    public function sliders(): MorphMany {
        return $this->morphMany(Slider::class, 'model');
    }

    public function area() {
        return $this->belongsTo(Area::class);
    }

    // Accessors
    public function getImageAttribute($image) {
        return !empty($image) ? url(Storage::url($image)) : $image;
    }

    public function getStatusAttribute($value) {
        return $this->deleted_at ? "inactive" : $value;
    }

    // Scopes
    public function scopeSearch($query, $search) {
        $search = "%" . $search . "%";
        return $query->where(function ($q) use ($search) {
            $q->orWhere('name', 'LIKE', $search)
                ->orWhere('description', 'LIKE', $search)
                ->orWhere('price', 'LIKE', $search)
                ->orWhere('image', 'LIKE', $search)
                ->orWhere('latitude', 'LIKE', $search)
                ->orWhere('longitude', 'LIKE', $search)
                ->orWhere('address', 'LIKE', $search)
                ->orWhere('contact', 'LIKE', $search)
                ->orWhere('show_only_to_premium', 'LIKE', $search)
                ->orWhere('status', 'LIKE', $search)
                ->orWhere('video_link', 'LIKE', $search)
                ->orWhere('clicks', 'LIKE', $search)
                ->orWhere('user_id', 'LIKE', $search)
                ->orWhere('country', 'LIKE', $search)
                ->orWhere('state', 'LIKE', $search)
                ->orWhere('city', 'LIKE', $search)
                ->orWhere('category_id', 'LIKE', $search)
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                });
        });
    }

    public function scopeOwner($query) {
        if (Auth::user()->hasRole('User')) {
            return $query->where('user_id', Auth::user()->id);
        }
        return $query;
    }

    public function scopeApproved($query) {
        return $query->where('status', 'approved');
    }

    public function scopeNotOwner($query) {
        return $query->where('user_id', '!=', Auth::user()->id);
    }

    public function scopeSort($query, $column, $order) {
        if ($column == "user_name") {
            return $query->leftJoin('users', 'users.id', '=', 'items.user_id')
                ->orderBy('users.name', $order)
                ->select('items.*');
        }
        return $query->orderBy($column, $order);
    }

    public function scopeFilter($query, $filterObject) {
        if (!empty($filterObject)) {
            foreach ($filterObject as $column => $value) {
                $query->where((string)$column, (string)$value);
            }
        }
        return $query;
    }

    public function scopeOnlyNonBlockedUsers($query) {
        $blocked_user_ids = BlockUser::where('user_id', Auth::user()->id)
            ->pluck('blocked_user_id');
        return $query->whereNotIn('user_id', $blocked_user_ids);
    }
}
