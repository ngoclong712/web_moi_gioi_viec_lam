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
            if (Schema::hasColumn('posts', 'min_salary')) {
                $table->float('min_salary')->nullable()->change();
            }
            if (Schema::hasColumn('posts', 'max_salary')) {
                $table->float('max_salary')->nullable()->change();
            }
            if (Schema::hasColumn('posts', 'currency_salary')) {
                $table->integer('currency_salary')->default(1)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
