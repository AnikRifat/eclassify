<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', static function (Blueprint $table) {
                $table->id();
                $table->string('title', 512);
                $table->string('slug', 512);
                $table->text('description')->nullable();
                $table->string('image', 512);
                $table->string('tags')->nullable();
                $table->integer('views')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('category_translations')) {
            Schema::create('category_translations', static function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
                $table->foreignId('language_id')->references('id')->on('languages')->onDelete('cascade');
                $table->string('name', 125);
                $table->timestamps();
                $table->unique(['category_id', 'language_id']);
            });
        }

        if (!Schema::hasTable('countries')) {
            Schema::create('countries', static function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->char('iso3', 3)->nullable();
                $table->char('numeric_code', 3)->nullable();
                $table->char('iso2', 2)->nullable();
                $table->string('phonecode', 255)->nullable();
                $table->string('capital', 255)->nullable();
                $table->string('currency', 255)->nullable();
                $table->string('currency_name', 255)->nullable();
                $table->string('currency_symbol', 255)->nullable();
                $table->string('tld', 255)->nullable();
                $table->string('native', 255)->nullable();
                $table->string('region', 255)->nullable();
                $table->integer('region_id')->nullable();
                $table->string('subregion', 255)->nullable();
                $table->integer('subregion_id')->nullable();
                $table->string('nationality', 255)->nullable();
                $table->text('timezones')->nullable();
                $table->text('translations')->nullable();
                $table->decimal('latitude')->nullable();
                $table->decimal('longitude')->nullable();
                $table->string('emoji', 191)->nullable();
                $table->string('emojiU', 191)->nullable();
                $table->boolean('flag')->nullable();
                $table->string('wikiDataId', 255)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('states')) {
            Schema::create('states', static function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->foreignId('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->char('state_code', 2);
                $table->string('fips_code', 255)->nullable();
                $table->string('iso2', 255)->nullable();
                $table->string('type', 191)->nullable();
                $table->decimal('latitude')->nullable();
                $table->decimal('longitude')->nullable();
                $table->boolean('flag')->nullable();
                $table->string('wikiDataId', 255)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('cities')) {
            Schema::create('cities', static function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->foreignId('state_id')->references('id')->on('states')->onDelete('cascade');
                $table->string('state_code', 255);
                $table->foreignId('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->char('country_code', 2);
                $table->decimal('latitude')->nullable();
                $table->decimal('longitude')->nullable();
                $table->boolean('flag')->nullable();
                $table->string('wikiDataId', 255)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', static function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->string('answer');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('social_logins')) {
            Schema::create('social_logins', static function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('firebase_id', 512);
                $table->enum('type', ['google', 'email', 'phone']);
                $table->timestamps();
                $table->unique(['user_id', 'type']);
            });
        }

        if (!Schema::hasTable('areas')) {
            Schema::create('areas', static function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->foreignId('city_id')->references('id')->on('cities')->onDelete('cascade');
                $table->foreignId('state_id')->references('id')->on('states')->onDelete('cascade');
                $table->string('state_code', 255)->nullable();
                $table->foreignId('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->timestamps();
            });
        }


        Schema::table('sliders', static function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'model_id') && !Schema::hasColumn('sliders', 'model_type')) {
                $table->nullableMorphs('model');
            }
        });


        Schema::table('user_purchased_packages', static function (Blueprint $table) {
            if (!Schema::hasColumn('user_purchased_packages', 'payment_transactions_id')) {
                $table->foreignId('payment_transactions_id')->after('used_limit')->nullable()->references('id')->on('payment_transactions')->onDelete('cascade');
            }
        });

        Schema::table('users', static function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'country_code')) {
                $table->string('country_code')->nullable();
            }
        });

        Schema::table('payment_transactions', static function (Blueprint $table) {
            if (Schema::hasColumn('payment_transactions', 'payment_id')) {
                $table->dropColumn('payment_id');
            }

            if (Schema::hasColumn('payment_transactions', 'payment_signature')) {
                $table->dropColumn('payment_signature');
            }

        });

        Schema::table('items', static function (Blueprint $table) {
            if (!Schema::hasColumn('items', 'area_id')) {
                $table->foreignId('area_id')->after('country')->nullable()->references('id')->on('areas')->onDelete('restrict');
            }

            if (!Schema::hasColumn('items', 'slug')) {
                $table->string('slug', 512)->after('name');
            }

            if (!Schema::hasColumn('items', 'rejected_reason')) {
                $table->string('rejected_reason')->after('status')->nullable();
            }
        });

        Schema::table('categories', static function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug', 512);
            }

        });

        Schema::table('languages', static function (Blueprint $table) {
            if (!Schema::hasColumn('languages', 'slug')) {
                $table->string('slug', 512)->after('name');
            }
            if (!Schema::hasColumn('languages', 'web_file')) {
                $table->string('web_file')->after('panel_file');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public
    function down(): void {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('social_logins');
        Schema::dropIfExists('areas');

        Schema::table('sliders', static function (Blueprint $table) {
            $table->dropMorphs('model');
        });

        Schema::table('user_purchased_packages', static function (Blueprint $table) {
            $table->dropColumn('payment_transactions_id');
        });

        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('country_code');
        });

        Schema::table('payment_transactions', static function (Blueprint $table) {
            $table->string('payment_id')->nullable();
            $table->string('payment_signature')->nullable();
        });

        Schema::table('languages', static function (Blueprint $table) {
            $table->dropColumn('web_file');
        });

        Schema::table('items', static function (Blueprint $table) {
            $table->dropColumn('area_id');
            $table->dropColumn('slug');
        });

        Schema::table('categories', static function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('languages', static function (Blueprint $table) {
            $table->dropColumn('web_file');
        });
    }
};
