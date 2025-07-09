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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();
            $table->string('order_no')->unique();
            $table->double('order_amount', 10, 2);
            $table->double('gst', 10, 2)->nullable();
            $table->string('cupon_used')->nullable();
            $table->boolean('has_discount')->default(false)->comment('0=No, 1=Yes');
            $table->double('discount_amount', 10, 2)->nullable();
            $table->double('total_amount', 10, 2)->nullable();
            $table->datetime('paid_at')->nullable();
            $table->string('transaction_code')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
