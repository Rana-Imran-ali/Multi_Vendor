<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('store_name');
            $table->string('logo')->nullable()->after('description');
        });

        // Backfill empty slugs
        DB::table('vendors')->whereNull('slug')->update([
            'slug' => DB::raw("lower(replace(store_name, ' ', '-'))")
        ]);
        
        // Remove the default unique constraint but keep it unique going forward if we can,
        // although SQLite handle this nicely with nullable first
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['slug', 'logo']);
        });
    }
};
