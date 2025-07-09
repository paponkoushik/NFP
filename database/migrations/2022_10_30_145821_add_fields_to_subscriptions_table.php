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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->after('user_id', function ($table) {
                $table->foreignUuid('organisation_id')->nullable()->index()->constrained()->nullOnDelete();
                $table->foreignId('plan_id')->nullable()->index()->constrained()->nullOnDelete();
                $table->date('subs_start_date');
                $table->date('form')->nullable();
                $table->date('to')->nullable();
                $table->string('payment_frequency')->nullable();
                $table->double('recurring_amount', 10, 2)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //
        });
    }
};
