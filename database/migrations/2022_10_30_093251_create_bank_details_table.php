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
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('organisation_id')->constrained()->cascadeOnDelete();
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bsb_no')->nullable();
            $table->string('bank_name');
            $table->string('bank_no')->nullable();
            $table->string('branch_name');
            $table->string('pay_id')->nullable();
            $table->boolean('is_default')->default(true)->comment('0=No, 1=Yes');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_details');
    }
};
