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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('city')->nullable();
            $table->string('state');
            $table->string('postcode', 20);
            $table->string('locality', 50);
            $table->string('address')->nullable();
            $table->string('region', 20)->nullable();
            $table->string('lat', 30)->nullable();
            $table->string('long', 30)->nullable();
            $table->string('sa4', 50)->nullable();
            $table->string('sa4_name', 50)->nullable();
            $table->string('lga_region', 50)->nullable();
            $table->string('lga_code', 50)->nullable();
            $table->char('country', 10)->default('au');
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
        Schema::dropIfExists('locations');
    }
};
