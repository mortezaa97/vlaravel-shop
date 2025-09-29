<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attribute_products', function (Blueprint $table) {
            $table->string('attribute_name')->after('attribute_id')->nullable();
            $table->string('attribute_slug')->after('attribute_id')->nullable();
            $table->string('attribute_value_title')->after('attribute_value_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_products', function (Blueprint $table) {
            $table->dropColumn('attribute_name');
            $table->dropColumn('attribute_slug');
            $table->dropColumn('attribute_value_title');
        });
    }
};
