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
        Schema::create('org_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index()
                ->constrained('categories')->cascadeOnDelete();
            $table->foreignUuid('organisation_id')->index()
                ->constrained('organisations')->cascadeOnDelete();
            $table->unique(['category_id', 'organisation_id']);
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
        Schema::dropIfExists('org_categories');
    }
};
