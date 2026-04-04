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
        // Add indexes to products
        Schema::table('products', function (Blueprint $table) {
            $table->index('name');
            $table->index('price');
            $table->index('status');
            $table->index('category_id');
        });

        // Create reviews table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->timestamps();
            
            // A user can only review a product once
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['price']);
            $table->dropIndex(['status']);
            $table->dropIndex(['category_id']);
        });
    }
};
