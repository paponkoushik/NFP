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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignUuid('organisation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->index()->constrained('collections')->cascadeOnDelete();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('created_by')->nullable()->index()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
};
