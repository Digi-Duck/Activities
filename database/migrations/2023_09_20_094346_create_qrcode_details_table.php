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
        Schema::create('qrcode_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('activity_id')->comment('活動id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('activity_id')->references('id')->on('activity_details')->onDelete('cascade');
            $table->unsignedBigInteger('student_id')->comment('學員id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('student_id')->references('id')->on('user_role_students')->onDelete('cascade');
            $table->string('qrcode_number')->comment('QRcode隨機碼');
            $table->string('qrcode_path')->comment('QRcode圖片路徑');
            $table->boolean('qrcode_status')->default(0)->comment('0:未掃描/1:已掃描');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcode_details');
    }
};
