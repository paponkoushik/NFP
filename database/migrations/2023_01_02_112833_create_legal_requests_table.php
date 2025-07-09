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
        Schema::create('legal_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('request_no')->index();
            $table->foreignId('comms_id')->index()->nullable()->constrained('comms')->cascadeOnDelete();
            $table->string('request_from', 30)->index()->nullable()->comment('org, post');
            $table->foreignUuid('listing_id')->index()->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('primary_org_id')->nullable()->constrained('organisations')->nullOnDelete()->comment('requested user orgId');
            $table->foreignUuid('secondary_org_id')->nullable()->constrained('organisations')->nullOnDelete();
            $table->foreignUuid('requested_user_id')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('legal_partner_id')->index()->nullable()->constrained('organisations')->nullOnDelete();
            $table->foreignUuid('legal_partner_admin_id')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('assigned_to')->index()->nullable()->comment('assign to')->constrained('users')->nullOnDelete();
            $table->text('additional_lawyer_note')->nullable();
            $table->text('advice_summary')->nullable()->comment('final summary by the lawyer');
            $table->boolean('is_request_accepted')->default(false)->comment('0=No, 1=Yes');
            $table->text('request_summary')->nullable()->comment('by the client');
            $table->double('billed_amount', 8, 2)->nullable()->comment('lawyer charge amount');
            $table->double('request_contract_amount', 8, 2)->nullable()->comment('if there is no agreed offer.');
            $table->boolean('is_offer_accepted')->default(false);
            $table->double('offered_amount', 8, 2)->nullable();
            $table->date('offered_date')->nullable();
            $table->double('agreed_amount', 8, 2)->nullable();
            $table->date('agreed_date')->nullable();
            $table->date('requested_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->foreignId('workflow_id')->index()->nullable()->constrained()->nullOnDelete();
            $table->string('workflow_status')->nullable();
            $table->string('workflow_stage')->index()->default('new');
            $table->foreignUuid('created_by')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_requests');
    }
};
