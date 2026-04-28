<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('rooms', function (Blueprint $table) {
                $table->unique('room_number');
            });
        } catch (\Exception $e) {
            // Index likely already exists
        }
    }
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropUnique(['room_number']);
        });
    }
};
