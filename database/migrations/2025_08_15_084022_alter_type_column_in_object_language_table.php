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
        Schema::table('object_language', function (Blueprint $table) {
            if (Schema::hasColumn('object_language', 'type')) {
                $table->string('type')->change();
                $table->renameColumn('type', 'object_type');
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
