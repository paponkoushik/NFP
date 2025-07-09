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
        Schema::create('org_pref_val_suburbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_pref_val_id')
                ->constrained('org_pref_values')->cascadeOnDelete();
            $table->string('suburb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_pref_val_suburbs');
    }
};
