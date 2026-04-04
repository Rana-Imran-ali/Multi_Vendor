<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add parent_id to categories
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
        });

        // 2. Modify products status column enum and default
        // For MySQL, recreating enum or dropping and adding it might be easier if doctrine DBAL is not installed.
        // Let's use raw query or String type for status to avoid enum modify issues.
        // But since this is a new app, we can just use DB statement for enum in MySQL.
        Schema::table('products', function (Blueprint $table) {
            // Drop enum and re-add or change data type.
            // A common workaround is to use string to avoid enum issues
            $table->string('status')->default('pending')->change();
        });

        // 3. Create Product Variants Table
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique()->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->timestamps();
        });

        // 4. Create Product Images Table
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_variants');
        
        Schema::table('products', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'suspended', 'rejected'])->default('active')->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
