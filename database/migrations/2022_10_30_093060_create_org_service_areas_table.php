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
        Schema::create('org_service_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_area_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();

            $table->unique(['service_area_id', 'organisation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_service_areas');
    }
};
