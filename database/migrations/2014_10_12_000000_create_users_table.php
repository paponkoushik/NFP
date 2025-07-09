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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('role')->default('user')->comment('super_admin, client_admin, user, legal_admin, lawyer, individual');
            $table->string('avatar')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('invitation_token')->nullable();
            $table->boolean('is_accept_terms')->default(false)->comment('0=No, 1=Yes');
            $table->boolean('is_online')->default(false)->comment('0=No, 1=Yes');
            $table->string('status')->default('inactive');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('created_by')->nullable()->index()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
