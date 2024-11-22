<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserLinkAddon extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        // Add columns
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('insta', 40)->nullable($value = true);
            $table->string('house', 60)->nullable($value = true);
            $table->string('disc', 40)->nullable($value = true);
            $table->string('arch', 50)->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('user_profiles', function (Blueprint $table) {
            //
            $table->dropColumn('insta');
            $table->dropColumn('house');
            $table->dropColumn('disc');
            $table->dropColumn('arch');
        });
    }
}
