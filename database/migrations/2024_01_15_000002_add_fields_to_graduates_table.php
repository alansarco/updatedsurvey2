<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('graduates', function (Blueprint $table) {
            if (!Schema::hasColumn('graduates', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('graduates', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('graduates', 'photo')) {
                $table->string('photo')->nullable();
            }
            // Skip current_employment as it already exists
        });
    }

    public function down(): void
    {
        Schema::table('graduates', function (Blueprint $table) {
            $table->dropColumn(['gender', 'facebook', 'photo']);
        });
    }
};
