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
        Schema::create('org_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index()
                ->constrained('categories')->cascadeOnDelete();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->index()->nullable()->constrained()->nullOnDelete();
            $table->string('type')->nullable()->comment('offer, looking, and both');
            $table->text('summary')->nullable();
            $table->timestamps();

            // $table->index(['organisation_id', 'slug']);
            $table->unique(['organisation_id', 'category_id', 'user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_preferences');
    }
};
