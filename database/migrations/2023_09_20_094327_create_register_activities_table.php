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
            $table->foreignId('activity_id')->constrained('activity_details')->onDelete('cascade')->comment('活動id');
            $table->foreignId('student_id')->constrained('user_role_students')->onDelete('cascade')->comment('學員id');
            $table->string('student_name', 50)->comment('學員報名姓名');
            $table->string('student_phone_number', 100)->comment('學員報名電話');
            $table->string('student_email')->comment('學員報名電子信箱');
            $table->text('student_additional_remark')->default('')->comment('學員報名額外備註');
            $table->unsignedTinyInteger('registration_status')->default(1)->comment('1:已報名/2:取消報名');
            $table->timestamps();
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
