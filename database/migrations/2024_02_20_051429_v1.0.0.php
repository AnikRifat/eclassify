<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('custom_fields', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('image');
            $table->boolean('required');
            $table->text('values')->nullable();
            $table->integer('min_length')->nullable();
            $table->integer('max_length')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('categories', static function (Blueprint $table) {
            $table->id();
            $table->integer('sequence')->nullable();
            $table->string('name');
            $table->string('image');
            $table->foreignId('parent_category_id')->nullable()->references('id')->on('categories')->onDelete('restrict');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('custom_field_categories', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('custom_field_id')->references('id')->on('custom_fields')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('items', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->double('price');
            $table->string('image');
            $table->string('watermark_image')->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->text('address');
            $table->string('contact');
            $table->boolean('show_only_to_premium');
            $table->enum('status', ['review', 'approved', 'rejected', 'sold out', 'featured']);
            $table->string('video_link')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->string('all_category_ids', 512)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('item_custom_field_values', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreignId('custom_field_id')->references('id')->on('custom_fields')->onDelete('cascade');
            $table->text('value')->nullable();
            $table->timestamps();
            $table->unique(['item_id', 'custom_field_id']);
        });

        Schema::create('languages', static function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('app_file');
            $table->string('panel_file');
            $table->boolean('rtl');
            $table->string('image', 512)->nullable();
            $table->timestamps();
        });

        Schema::create('item_images', static function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('settings', static function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('value')->nullable();
            $table->enum('type', ['string', 'file'])->default('string');
            $table->timestamps();
        });

        Schema::create('packages', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->integer('discount_price')->default(0);
            $table->string('duration');
            $table->string('item_limit');
            $table->string('type');
            $table->string('icon');
            $table->longText('description');
            $table->tinyInteger('status')->default(1);
            $table->string('ios_product_id', 512)->nullable();
            $table->timestamps();
        });

        Schema::create('sliders', static function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('sequence');
            $table->string('third_party_link')->nullable();
            $table->integer('item_id')->nullable();
            $table->timestamps();
        });

        Schema::create('report_reasons', static function (Blueprint $table) {
            $table->id();
            $table->longText('reason');
            $table->timestamps();
        });

        Schema::create('user_reports', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_reason_id')->nullable()->references('id')->on('report_reasons')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');
            /*TODO : why there are 2 column other_message & reason*/
            $table->longText('other_message')->nullable();
            $table->longText('reason');
            $table->timestamps();
        });

        Schema::create('user_purchased_packages', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('total_limit')->nullable();
            $table->integer('used_limit')->default(0);

            $table->timestamps();
        });

        Schema::create('feature_sections', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('sequence');
            $table->string('filter');
            $table->string('value')->nullable();
            $table->string('style');
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications', static function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('message');
            $table->text('image');
            $table->foreignId('item_id')->nullable()->references('id')->on('items')->onDelete('cascade');
            $table->enum('send_to', ['all', 'selected']);
            $table->string('user_id', 512)->nullable();
            $table->timestamps();
        });

        Schema::create('featured_items', static function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreignId('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreignId('user_purchased_package_id')->references('id')->on('user_purchased_packages')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['item_id', 'package_id']);
        });

        Schema::create('favourites', static function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');
        });

        Schema::create('payment_configurations', static function (Blueprint $table) {
            $table->id();
            $table->string('payment_method');
            $table->string('api_key');
            $table->string('secret_key');
            $table->string('webhook_secret_key');
            $table->string('currency_code', 128)->nullable();
            $table->boolean('status')->comment('0 - Disabled, 1 - Enabled')->default(1);
            $table->timestamps();
        });

        Schema::create('payment_transactions', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('amount', 8, 2);
            $table->string('payment_gateway', 128);
            $table->string('order_id')->comment('order_id / payment_intent_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_signature')->nullable();
            $table->enum('payment_status', ['failed', 'succeed', 'pending']);
            $table->timestamps();
            $table->unique(['payment_gateway', 'order_id']);
        });


        Schema::table('roles', static function (Blueprint $table) {
            $table->boolean('custom_role')->after('guard_name')->default(0);
        });

        Schema::create('item_offers', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->float('amount');
            $table->timestamps();
            /*Seller id is redundant here to adding it to the unique constraint will be the wastage*/
            $table->unique(['buyer_id', 'item_id']);
        });

        Schema::create('chats', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('item_offer_id')->references('id')->on('item_offers')->onDelete('cascade');
            $table->string('message');
            $table->string('file')->nullable();
            $table->string('audio')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('custom_field_categories');
        Schema::dropIfExists('item_custom_field_values');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_images');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('report_reasons');
        Schema::dropIfExists('user_reports');
        Schema::dropIfExists('user_purchased_packages');
        Schema::dropIfExists('feature_sections');
        Schema::dropIfExists('notification');
        Schema::dropIfExists('advertisements');
        Schema::dropIfExists('favourites');
        Schema::dropIfExists('payment_configurations');
    }
};
