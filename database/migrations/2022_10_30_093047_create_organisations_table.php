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
        Schema::create('organisations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('org_type', 25)->default('client')->comment('client/legal_partner');
            $table->string('org_name')->index();
            $table->string('slug')->unique();
            $table->string('abn')->nullable();
            $table->string('acn')->nullable();
            $table->string('client_type')->nullable()->comment('nfp/fp/charity/individual');
            // $table->string('address')->nullable();
            // $table->string('city')->nullable();
            // $table->string('state')->nullable();
            // $table->string('postcode')->nullable();
            $table->string('logo')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('summary')->nullable();
            $table->text('details')->nullable();
            $table->string('alias', 50)->nullable()->comment('auto generated anonymous name e.g: Anonymous 4000,199');
            $table->string('website')->nullable();
            $table->unsignedSmallInteger('max_user')->default(1);
            $table->text('others')->nullable();
            $table->string('status', 20)->default('inactive');
            $table->timestamp('set_preference_at');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('created_by')->index()->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisations');
    }
};
