<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('address')->nullable()->after('phone');
            $table->date('birthdate')->nullable()->after('address');
            $table->integer('age')->nullable()->after('birthdate');
            $table->enum('gender', ['male', 'female'])->nullable()->after('age');
            $table->string('avatar')->nullable()->after('gender');
            $table->softDeletes()->after('updated_at');
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