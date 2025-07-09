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
        Schema::create('comms', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('listing_id')->index()->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('to_org_id')->index()->constrained('organisations')->cascadeOnDelete();
            $table->boolean('to_org_anonymous')->default(true);
            $table->foreignUuid('from_org_id')->index()->nullable()->constrained('organisations')->nullOnDelete();
            $table->boolean('from_org_anonymous')->default(true);
            $table->boolean('is_offered')->default(false);
            $table->string('offered_amount')->nullable();
            $table->string('offer_status')->default('pending')->comment('pending, accept, reject, cancel');
            $table->timestamp('from_org_last_seen_at')->nullable();
            $table->timestamp('to_org_last_seen_at')->nullable();
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
        Schema::dropIfExists('comms');
    }
};
