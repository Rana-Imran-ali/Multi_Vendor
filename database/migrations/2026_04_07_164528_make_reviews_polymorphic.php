<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convert reviews from product-only to fully polymorphic.
     * Existing product reviews are migrated in-place before the old column is dropped.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Remove old FK first
            $table->dropForeign(['product_id']);
            
            // Add a dedicated index for user_id so the foreign key doesn't block dropping the unique index
            $table->index('user_id');

            // Drop old unique constraint that used product_id
            $table->dropUnique(['user_id', 'product_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            // Add polymorphic columns (nullable so existing rows can be backfilled first)
            $table->unsignedBigInteger('reviewable_id')->nullable()->after('id');
            $table->string('reviewable_type')->nullable()->after('reviewable_id');
        });

        // Back-fill existing product reviews
        DB::table('reviews')->whereNotNull('product_id')->update([
            'reviewable_id'   => DB::raw('product_id'),
            'reviewable_type' => "App\\Models\\Product",
        ]);

        Schema::table('reviews', function (Blueprint $table) {
            // Make polymorphic columns required now that data is backfilled
            $table->unsignedBigInteger('reviewable_id')->nullable(false)->change();
            $table->string('reviewable_type')->nullable(false)->change();

            // Drop old product_id column
            $table->dropColumn('product_id');

            // New unique constraint prevents a user from double-reviewing the same item
            $table->unique(['user_id', 'reviewable_id', 'reviewable_type']);

            // Index for polymorphic lookups
            $table->index(['reviewable_id', 'reviewable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
        });
    }
};
