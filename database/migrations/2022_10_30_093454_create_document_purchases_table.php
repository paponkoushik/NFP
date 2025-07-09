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
        Schema::create('document_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('document_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();
            $table->datetime('purchase_at')->nullable();
            $table->string('download_hash')->nullable();
            $table->integer('total_download')->default(0);
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
        Schema::dropIfExists('document_purchases');
    }
};
