<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Soft deletes so reviews are recoverable
            $table->softDeletes();

            // Moderation status — approved reviews appear publicly
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('approved') // auto-approve for now; swap to 'pending' for pre-moderation
                  ->after('comment');

            // Helpful votes
            $table->unsignedInteger('helpful_count')->default(0)->after('status');

            // Optional title for the review headline
            $table->string('title', 160)->nullable()->after('rating');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['status', 'helpful_count', 'title']);
        });
    }
};
