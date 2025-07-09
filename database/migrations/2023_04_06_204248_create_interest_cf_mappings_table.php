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
    public function up()
    {
        Schema::create('interest_cf_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interest_id')->index();
            $table->unsignedBigInteger('custom_field_id')->index();
            $table->string('slug', 20)->nullable();
            $table->string('label')->nullable();
            $table->string('def_value')->nullable();
            $table->unsignedSmallInteger('sequence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interest_cf_mappings');
    }
};
