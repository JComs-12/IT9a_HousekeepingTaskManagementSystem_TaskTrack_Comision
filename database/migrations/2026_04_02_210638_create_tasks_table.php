<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')
                  ->constrained('rooms')
                  ->onDelete('cascade');
            $table->foreignId('staff_id')
                  ->constrained('staff')
                  ->onDelete('cascade');
            $table->string('task_name');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('medium');
            $table->date('due_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};