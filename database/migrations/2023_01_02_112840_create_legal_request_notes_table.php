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
        Schema::create('legal_request_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('legal_request_id')->index()->constrained()->cascadeOnDelete();
            $table->string('stage');
            $table->string('step');
            $table->text('note');
            $table->foreignUuid('created_by')->index()->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('legal_request_notes');
    }
};
