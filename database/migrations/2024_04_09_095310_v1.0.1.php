<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {

        if (!Schema::hasColumn('items', 'clicks')) {
            Schema::table('items', static function (Blueprint $table) {
                $table->integer('clicks')->after('all_category_ids');
            });
        }

        Schema::table('languages', static function (Blueprint $table) {
            $table->string('name_in_english', 32)->after('name');
        });

        Schema::table('chats', static function (Blueprint $table) {
            $table->string('message')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('items', static function (Blueprint $table) {
            $table->dropColumn('clicks');
        });

        Schema::table('languages', static function (Blueprint $table) {
            $table->dropColumn('name_in_english');
        });

        Schema::table('chats', static function (Blueprint $table) {
            $table->string('message')->change();
        });
    }
};
