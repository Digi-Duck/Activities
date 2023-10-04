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
            $table->timestamps();
            $table->unsignedBigInteger('student_id')->comment('學員id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('student_id')->references('id')->on('user_role_students')->onDelete('cascade');
            $table->unsignedBigInteger('activity_id')->comment('活動id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('activity_id')->references('id')->on('activity_details')->onDelete('cascade');
            $table->integer('activity_type')->comment('1:已收藏的活動/2:已報名的活動');
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
