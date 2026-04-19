<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Create pivot table
        Schema::create('task_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['task_id', 'staff_id']);
        });

        // Migrate existing single staff_id data into pivot
        $tasks = DB::table('tasks')->whereNotNull('staff_id')->get();
        foreach ($tasks as $task) {
            DB::table('task_staff')->insertOrIgnore([
                'task_id'    => $task->id,
                'staff_id'   => $task->staff_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Drop old staff_id column from tasks
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('cascade');
        });

        Schema::dropIfExists('task_staff');
    }
};