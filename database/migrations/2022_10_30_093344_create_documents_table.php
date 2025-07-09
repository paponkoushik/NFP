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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('path');
            $table->string('file_type')->default('docx');
            $table->integer('total_download')->default(0);
            $table->integer('total_purchased')->default(0);
            $table->foreignUuid('organisation_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->string('status')->default('published')->comment('draft, published, in-review');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('created_by')->nullable()->index()->constrained('users')->nullOnDelete();
            $table->foreignUuid('updated_by')->nullable()->index()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
