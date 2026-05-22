<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            if (!Schema::hasColumn('staff', 'first_name'))
                $table->string('first_name')->nullable()->after('name');
            if (!Schema::hasColumn('staff', 'last_name'))
                $table->string('last_name')->nullable()->after('first_name');
            if (!Schema::hasColumn('staff', 'address'))
                $table->string('address')->nullable()->after('phone');
            if (!Schema::hasColumn('staff', 'birthdate'))
                $table->date('birthdate')->nullable()->after('address');
            if (!Schema::hasColumn('staff', 'age'))
                $table->integer('age')->nullable()->after('birthdate');
            if (!Schema::hasColumn('staff', 'gender'))
                $table->string('gender')->nullable()->after('age');
            if (!Schema::hasColumn('staff', 'avatar'))
                $table->string('avatar')->nullable()->after('gender');
            if (!Schema::hasColumn('staff', 'deleted_at'))
                $table->softDeletes()->after('updated_at');
            if (!Schema::hasColumn('staff', 'deletion_reason'))
                $table->string('deletion_reason')->nullable()->after('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'address', 'birthdate', 'age', 'gender', 'avatar', 'deleted_at', 'deletion_reason']);
        });
    }
};