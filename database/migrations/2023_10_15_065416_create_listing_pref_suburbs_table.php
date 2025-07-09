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
        Schema::create('listing_pref_suburbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_preference_id')
                ->constrained('listing_preferences')->cascadeOnDelete();
            $table->string('suburb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_pref_suburbs');
    }
};
