<?php

use App\Models\Blog;
use App\Models\Category;
use App\Models\FeatureSection;
use App\Models\Item;
use App\Models\User;
use App\Models\UserFcmToken;
use App\Services\HelperService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('feature_sections', static function (Blueprint $table) {
            $table->string('slug', 512)->after('title');
        });

        FeatureSection::chunk(100, static function ($data) {
            foreach ($data as $featureSection) {
                $featureSection->update([
                    'slug' => HelperService::generateUniqueSlug(new FeatureSection(), $featureSection->title, $featureSection->id)
                ]);
            }
        });

        Schema::table('feature_sections', static function (Blueprint $table) {
            $table->unique('slug');
        });

        Blog::chunk(100, static function ($data) {
            foreach ($data as $blog) {
                $blog->update([
                    'slug' => HelperService::generateUniqueSlug(new Blog(), $blog->title, $blog->id)
                ]);
            }
        });

        Item::withTrashed()->chunk(100, static function ($items) {
            foreach ($items as $item) {
                $item->update([
                    'slug' => HelperService::generateUniqueSlug(new Item(), $item->name, $item->id),
                ]);
            }
        });
        Schema::table('items', static function (Blueprint $table) {
            $table->unique('slug');
            if (!Schema::hasColumn('items', 'rejected_reason')) {
                $table->string('rejected_reason')->after('status')->nullable();
            }
        });

        Category::chunk(100, static function ($categories) {
            foreach ($categories as $category) {
                $category->update([
                    'slug' => HelperService::generateUniqueSlug(new Category(), $category->name, $category->id)
                ]);
            }
        });

        Schema::table('categories', static function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('languages', static function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::useNativeSchemaOperationsIfPossible();
        Schema::table('social_logins', static function (Blueprint $table) {
            $table->enum('type', ['google', 'email', 'phone', 'apple'])->change();
        });

        Schema::create('contact_us', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('user_fcm_tokens', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('fcm_token');
            $table->timestamps();
            $table->unique('fcm_token');
        });

        $tokens = [];
        foreach (User::whereNotNull('fcm_id')->whereNot('fcm_id', '')->get() as $user) {
            $tokens[] = [
                'user_id'    => $user->id,
                'fcm_token'  => $user->fcm_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        if (count($tokens) > 0) {
            UserFcmToken::insertOrIgnore($tokens);
        }

        Schema::table('users', static function (Blueprint $table) {
            $table->string('fcm_id')->comment('remove this in next update')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('feature_sections', static function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('blogs', static function (Blueprint $table) {
            $table->dropUnique('blogs_slug_unique');
        });

        Schema::table('items', static function (Blueprint $table) {
            $table->dropUnique('slug');
        });

        Schema::table('categories', static function (Blueprint $table) {
            $table->dropUnique('slug');
        });

        Schema::table('languages', static function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        Schema::useNativeSchemaOperationsIfPossible();
        Schema::table('social_logins', static function (Blueprint $table) {
            $table->enum('type', ['google', 'email', 'phone'])->change();
        });

        Schema::dropIfExists('contact_us');
        Schema::dropIfExists('user_fcm_tokens');

        Schema::table('users', static function (Blueprint $table) {
            $table->string('fcm_id')->comment('')->change();
        });
    }
};
