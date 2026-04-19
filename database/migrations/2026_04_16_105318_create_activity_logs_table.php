<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('role')->default('admin'); // 'admin' or 'staff'
            $table->string('action');                 // e.g. 'Task Created', 'Status Updated'
            $table->string('description');            // human-readable detail
            $table->string('subject_type')->nullable(); // e.g. 'Task', 'Room'
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};