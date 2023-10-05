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
        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('user_role_students')->onDelete('cascade')->comment('學員id');
            $table->foreignId('activity_id')->constrained('activity_details')->onDelete('cascade')->comment('活動id');
            $table->unsignedTinyInteger('activity_type')->comment('1:已收藏的活動/2:已報名的活動');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_activities');
    }
};
