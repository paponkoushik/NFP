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
        Schema::table('categories', function (Blueprint $table) {
            $table->string("exclude_for")
                ->comment('Exclude category for organisation or individual. Value should be org or inv.')
                ->nullable()->after("status");
            $table->text("exclude_fields")
                ->comment('Exclude fields for organisation or individual.')
                ->nullable()->after("exclude_for");
            $table->text("exclude_field_values")
                ->comment('Exclude field values for organisation or individual.')
                ->nullable()->after("exclude_fields");
            $table->text("custom_label")
                ->nullable()->after("exclude_field_values");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                "exclude_for",
                "exclude_fields",
                "exclude_field_values",
                "custom_label",
            ]);
        });
    }
};
