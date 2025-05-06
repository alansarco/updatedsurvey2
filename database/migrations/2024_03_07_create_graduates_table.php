<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('graduates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('graduation_year');
            $table->string('phone_number');
            $table->string('gender');
            $table->string('facebook')->nullable();
            $table->string('photo')->nullable();
            $table->string('position')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('industry_sector')->nullable();
            $table->boolean('is_cpe_related')->default(false);
            $table->boolean('has_awards')->default(false);
            $table->boolean('is_involved_organizations')->default(false);
            $table->boolean('employed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('graduates');
    }
};
