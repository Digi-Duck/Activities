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
            $table->foreignId('activity_id')->constrained('activity_details')->onDelete('cascade')->comment('活動id');
            $table->foreignId('student_id')->constrained('user_role_students')->onDelete('cascade')->comment('學員id');
            $table->string('qrcode_number')->nullable()->comment('QRcode隨機碼');
            $table->text('qrcode_path')->comment('QRcode圖片路徑');
            $table->boolean('qrcode_status')->default(0)->comment('0:未掃描/1:已掃描');
            $table->timestamps();
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
