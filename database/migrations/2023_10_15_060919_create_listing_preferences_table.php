<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listing_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('listing_id')->index()->constrained('listings')->cascadeOnDelete();
            $table->string('where', 40)->nullable()
                ->comment('australia-wide, states, local-area, suburbs, radius etc.');
            $table->string('radius')->nullable()
                ->comment('radius in km');
            $table->string('radius_location')->nullable()
                ->comment('radius location saved postcode.');
            $table->string('when', 40)->nullable()
                ->comment('ongoing, date-range, fixed-date etc.');
            $table->date('date')->nullable()
                ->comment('it used when - when is only date.');
            $table->date('from_date')->nullable()
                ->comment('it used when - when is date-range.');
            $table->date('to_date')->nullable()
                ->comment('it used when - when is date-range.');
            $table->string('cost', 40)->nullable()
                ->comment('no-cost, range, fixed etc.');
            $table->double('amount')->nullable()
                ->comment('it used when - cost is fixed.');
            $table->double('from_amount')->nullable()
                ->comment('it used when - cost is range.');
            $table->double('to_amount')->nullable()
                ->comment('it used when - cost is range.');
            $table->string('frequency', 40)->nullable()
                ->comment('daily, weekly, monthly, yearly etc.');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->foreignId('location_id')->nullable()
                ->constrained('locations')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_preferences');
    }
};
