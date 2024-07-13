<?php

use App\Models\Category;
use App\Models\Item;
use App\Models\Slider;
use App\Models\SocialLogin;
use App\Models\User;
use App\Services\HelperService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /* 1. Slider Changes */

        if (Schema::hasColumn('sliders', 'item_id')) {
            foreach (Slider::whereNot('item_id', 0)->get() as $slider) {
                $item = Item::find($slider->item_id);
                if ($item) {
                    $slider->model()->associate($item);
                    $slider->save();
                } else {
                    $slider->delete();
                }
            }

            try {
                Schema::disableForeignKeyConstraints();
                Schema::table('sliders', static function (Blueprint $table) {
                    $table->dropColumn('item_id');
                });
                Schema::enableForeignKeyConstraints();
            } catch (Exception $e) {
                // Foreign key doesn't exist, so just catch the exception and move on.
            }
        }
        /* 2. User Changes */
        $socialLogin = [];
        $userRole = (new Spatie\Permission\Models\Role)->where('name', 'User')->count();
        if ($userRole > 0) {
            foreach (User::role('User')->whereNotNull('firebase_id')->get() as $user) {
                $socialLogin[] = [
                    'firebase_id' => $user->firebase_id,
                    'type'        => $user->type,
                    'user_id'     => $user->id
                ];
            }
            if (count($socialLogin) > 0) {
                SocialLogin::upsert($socialLogin, ['user_id', 'type'], ['firebase_id']);
            }
        }

        Schema::table('users', static function (Blueprint $table) {
            $table->string('firebase_id')->comment('remove in next update')->nullable()->change();
            $table->string('type')->comment('remove in next update')->nullable()->change();
        });


        /* 3.Slug Generation */

        Category::chunk(100, static function ($categories) {
            $tempCategories = [];
            foreach ($categories as $category) {
                $tempCategories[] = [
                    'id'   => $category->id,
                    'slug' => HelperService::generateUniqueSlug(new Category(), $category->name, $category->id)
                ];
            }

            if (count($tempCategories) > 0) {
                Category::upsert($tempCategories, ['id'], ['slug']);
            }
        });

        Item::withTrashed()->chunk(100, static function ($items) {
            $tempItems = [];
            foreach ($items as $item) {
                $tempItems[] = [
                    'id'     => $item->id,
                    'slug'   => HelperService::generateUniqueSlug(new Item(), $item->name, $item->id),
                    'status' => $item->status == "featured" ? "approved" : $item->status
                ];
            }

            if (count($tempItems) > 0) {
                Item::upsert($tempItems, ['id'], ['slug', 'status']);
            }
        });
        Schema::useNativeSchemaOperationsIfPossible();
        Schema::table('items', static function (Blueprint $table) {
            //Featured status removed
            $table->enum('status', ['review', 'approved', 'rejected', 'sold out'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('sliders', static function (Blueprint $table) {
            $table->foreignId('item_id')->nullable()->references('id')->on('items')->onDelete('cascade');
        });
        foreach (Slider::whereHasMorph('model', Item::class)->get() as $slider) {
            $slider->item_id = $slider->model_id;
            $slider->save();
        }

        Schema::table('users', static function (Blueprint $table) {
            $table->string('type')->comment('email/google/mobile')->nullable(false)->change();
            $table->string('firebase_id')->nullable(false)->change();
        });
    }
};
