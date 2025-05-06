<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('graduates', function (Blueprint $table) {
        $table->enum('lifelong_learner', ['yes', 'no'])->nullable()->after('is_involved_organizations');
    });
}

public function down()
{
    Schema::table('graduates', function (Blueprint $table) {
        $table->dropColumn('lifelong_learner');
    });
}
};
