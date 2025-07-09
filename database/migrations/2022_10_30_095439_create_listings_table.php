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
        Schema::create('listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->index()->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->index()->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('looking')->comment('looking/offer');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->integer('visits')->default(0);
            $table->boolean('is_anonymous')->default(false)->comment('0=No, 1=Yes');
            $table->datetime('archived_at')->nullable();
            $table->text('images')->nullable();
            $table->string('status', 30)->default('draft')->comment('draft,open,closed,hidden');
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
};
