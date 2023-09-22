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
        Schema::create('register_activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('activity_id')->comment('活動id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('activity_id')->references('id')->on('activity_details')->onDelete('cascade');
            $table->unsignedBigInteger('student_id')->comment('學員id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('student_id')->references('id')->on('user_role_students')->onDelete('cascade');
            $table->string('student_name', 50)->comment('學員報名姓名');
            $table->string('student_phone_number', 100)->comment('學員報名電話');
            $table->string('student_email')->comment('學員報名電子信箱');
            $table->text('student_additional_remark')->default('')->comment('學員報名額外備註');
            $table->integer('registration_status')->default(1)->comment('1:已報名/2:取消報名');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_activities');
    }
};
