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
        Schema::create('org_users', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUuid('organisation_id')->index()->constrained()->cascadeOnDelete();
            $table->string('role', 20)->default('admin');
            $table->boolean('is_primary')->default(1);
            $table->string('status', 20)->default('active');

            $table->unique(['user_id', 'organisation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_users');
    }
};
