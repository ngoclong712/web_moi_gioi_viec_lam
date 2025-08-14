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
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_parttime')->nullable()->default(0)->change();
            $table->integer('remote')->nullable()->change();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('is_parttime', 'can_parttime');
            $table->renameColumn('remote', 'remotable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
