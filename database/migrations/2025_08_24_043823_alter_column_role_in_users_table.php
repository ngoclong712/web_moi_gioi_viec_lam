<?php

use App\Enums\UserRoleEnum;
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
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('role')->default(UserRoleEnum::APPLICANT)->change();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
