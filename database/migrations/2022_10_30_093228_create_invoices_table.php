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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->index()->constrained()->cascadeOnDelete();
            $table->string('invoice_no');
            $table->double('original_amount', 10, 2);
            $table->double('invoice_amount', 10, 2);
            $table->date('invoice_date')->nullable();
            $table->date('payment_from')->nullable();
            $table->date('payment_to')->nullable();
            $table->string('payment_on')->nullable();
            $table->text('invoice_details')->nullable();
            $table->text('payment_details')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('due')->comment('due, paid');
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
        Schema::dropIfExists('invoices');
    }
};
