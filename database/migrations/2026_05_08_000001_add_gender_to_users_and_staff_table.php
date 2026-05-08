<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'gender')) {
                $after = Schema::hasColumn('users', 'age') ? 'age' : (Schema::hasColumn('users', 'birthdate') ? 'birthdate' : 'email');
                $table->string('gender')->nullable()->after($after);
            }
        });

        Schema::table('staff', function (Blueprint $table) {
            if (!Schema::hasColumn('staff', 'gender')) {
                $after = Schema::hasColumn('staff', 'age') ? 'age' : (Schema::hasColumn('staff', 'birthdate') ? 'birthdate' : 'email');
                $table->string('gender')->nullable()->after($after);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};
