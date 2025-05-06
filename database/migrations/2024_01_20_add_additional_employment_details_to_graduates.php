<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('graduates', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('industry_sector')->nullable();
            $table->boolean('is_cpe_related')->nullable();
            $table->boolean('has_awards')->nullable();
            $table->boolean('is_involved_organizations')->nullable();
        });
    }

    public function down()
    {
        Schema::table('graduates', function (Blueprint $table) {
            $table->dropColumn([
                'position',
                'company_name',
                'company_address',
                'industry_sector',
                'is_cpe_related',
                'has_awards',
                'is_involved_organizations'
            ]);
        });
    }
};
