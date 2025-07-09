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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('listing_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('offered_org_id')->index()->nullable()->constrained('organisations')->nullOnDelete();
            $table->foreignId('comms_id')->index()->constrained('comms')->cascadeOnDelete();
            $table->timestamp('offered_at');
            $table->text('offer_details')->nullable();
            $table->double('offer_amount', 10, 2)->nullable();
            $table->double('agreed_amount', 10, 2)->nullable();
            $table->string('price_type')->default('paid')->comment('free, na, paid');
            $table->boolean('is_fixed_price')->default(false)->comment('0=No, 1=Yes');
            $table->timestamp('offered_accepted_at')->nullable();
            $table->text('note')->nullable();
            $table->string('status', 30)->default('pending')->comment('[reject,accept,pending,cancel]');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('created_by')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('updated_by')->index()->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
