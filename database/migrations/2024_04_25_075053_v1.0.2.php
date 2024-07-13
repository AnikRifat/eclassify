<?php

use App\Models\Package;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Setting::insert([
            ['name' => 'banner_ad_id_android', 'value' => ''],
            ['name' => 'banner_ad_id_ios', 'value' => ''],
            ['name' => 'banner_ad_status', 'value' => 1],

            ['name' => 'interstitial_ad_id_android', 'value' => ''],
            ['name' => 'interstitial_ad_id_ios', 'value' => ''],
            ['name' => 'interstitial_ad_status', 'value' => 1],
        ]);

        Schema::table('packages', static function (Blueprint $table) {
            /*Rename the column*/
            $table->renameColumn('price', 'final_price');
            $table->renameColumn('discount_price', 'price');

            /*Add new column*/
            $table->float('discount_in_percentage')->after('price')->default(0);
        });

        /*This code is added separately because datatype was not changing when running in the code snippet*/
        Schema::table('packages', static function (Blueprint $table) {
            $table->float('price')->after('name')->change();
            $table->float('final_price')->after('discount_in_percentage')->change();
        });

        foreach (Package::whereNot('final_price', 0)->get() as $package) {
            $package->price = $package->final_price;
            $package->save();
        }

        Schema::table('items', static function (Blueprint $table) {
            $table->string('state')->nullable()->change();
        });

        Schema::create('block_users', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('blocked_user_id')->references('id')->on('users')->onDelete('restrict');
            $table->unique(['user_id', 'blocked_user_id']);
            $table->timestamps();
        });

        Schema::create('tips', static function (Blueprint $table) {
            $table->id();
            $table->string('description', 512);
            $table->integer('sequence');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tip_translations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('tip_id')->references('id')->on('tips')->onDelete('cascade');
            $table->foreignId('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('description', 512);
            $table->timestamps();
            $table->unique(['tip_id', 'language_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Setting::whereIn('name', [
            'banner_ad_id_android',
            'banner_ad_id_ios',
            'banner_ad_status',
            'interstitial_ad_id_android',
            'interstitial_ad_id_ios',
            'interstitial_ad_status',
        ])->delete();

        Schema::table('packages', static function (Blueprint $table) {
            /*Rename the column*/
            $table->renameColumn('price', 'discount_price');
            $table->renameColumn('final_price', 'price');

            /*Add new column*/
            $table->dropColumn('discount_in_percentage');
        });

        /*This code is added separately because datatype was not changing when running in the code snippet*/
        Schema::table('packages', static function (Blueprint $table) {
            /*Change Datatype of old columns*/
            $table->integer('price')->change();
            $table->integer('discount_price')->change();
        });

        Schema::table('items', static function (Blueprint $table) {
            $table->string('state')->nullable(false)->change();
        });

        Schema::dropIfExists('block_users');
        Schema::dropIfExists('tips');
        Schema::dropIfExists('tip_translations');

    }
};
