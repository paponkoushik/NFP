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
        Schema::create('org_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interest_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();

            $table->unique(['interest_id', 'organisation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_interests');
    }
};
