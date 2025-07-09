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
        Schema::create('document_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('document_id')->index()->constrained()->cascadeOnDelete();
            $table->timestamps();
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
        Schema::dropIfExists('document_tags');
    }
};
