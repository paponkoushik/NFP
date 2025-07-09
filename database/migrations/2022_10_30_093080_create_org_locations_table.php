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
        Schema::create('org_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->nullable()->index();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();
            $table->string('city');
            $table->string('state');
            $table->string('postcode');
            $table->string('address')->nullable();
            $table->string('locality', 50)->nullable();
            $table->string('lat', 30)->nullable();
            $table->string('long', 30)->nullable();
            $table->string('sa4', 50)->nullable();
            $table->string('sa4_name', 50)->nullable();
            $table->string('lga_region', 50)->nullable();
            $table->string('lga_code', 50)->nullable();
            $table->boolean('is_primary')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_locations');
    }
};
