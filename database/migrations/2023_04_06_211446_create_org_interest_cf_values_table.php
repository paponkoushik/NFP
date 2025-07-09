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
        Schema::create('org_interest_cf_values', function (Blueprint $table) {
            $table->id();
            $table->uuid('organisation_id')->index();
            $table->unsignedBigInteger('interest_cf_mapping_id')->index();
            $table->string('value');
            $table->string('offerring')->nullable();
            $table->string('looking_for')->nullable();
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
        Schema::dropIfExists('org_interest_cf_values');
    }
};
