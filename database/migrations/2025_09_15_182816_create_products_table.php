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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('english_name')->nullable();
            $table->string('code')->unique();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('hover')->nullable();
            $table->json('gallery')->nullable();
            $table->longText('excerpt')->nullable();
            $table->longText('desc')->nullable();
            $table->decimal('price', 19, 0)->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->string('sku')->nullable(); // Warehouse ID
            $table->decimal('sale_price', 19, 0)->nullable();
            $table->decimal('partner_price', 19, 0)->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->decimal('delivery_price', 19, 0)->nullable(); // hazine tahvil - delivery price
            $table->decimal('time_to_send')->nullable(); // hazine tahvil be ezaye har mahsool - delivery price per product
            $table->decimal('user_price', 19, 0)->nullable();

            $table->string('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->smallInteger('status')->nullable();
            $table->bigInteger('views')->default(0);
            $table->boolean('is_original')->default(false);
            $table->smallInteger('increase_step')->default(1);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
