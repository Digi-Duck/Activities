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
        Schema::create('activity_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presenter_id')->constrained('user_role_presenters')->onDelete('cascade')->comment('講者id');
            $table->string('activity_name')->comment('活動名稱');
            $table->string('activity_info')->comment('活動Slogan');
            $table->string('activity_presenter')->comment('活動講者');
            $table->unsignedTinyInteger('activity_type')->comment('1:文化與藝術/2:學術與培訓/3:社交與社團/4:旅遊與戶外/5:健康與福祉/6:商業與職業發展/7:娛樂與文化慶典/8:科技與創新/9:其他');
            $table->unsignedInteger('activity_lowest_number_of_people')->comment('活動人數下限');
            $table->unsignedInteger('activity_highest_number_of_people')->comment('活動人數上限');
            $table->dateTime('activity_start_registration_time')->comment('活動報名開始時間');
            $table->dateTime('activity_end_registration_time')->comment('活動報名截止時間');
            $table->dateTime('activity_start_time')->comment('活動開始時間');
            $table->dateTime('activity_end_time')->comment('活動結束時間');
            $table->string('activity_address')->comment('活動地點');
            $table->string('activity_phone_number')->comment('活動主動連絡電話');
            $table->string('activity_email')->comment('活動主動連絡信箱');
            $table->string('activity_instruction')->comment('活動參加須知');
            $table->text('activity_information')->comment('活動詳情');
            $table->unsignedTinyInteger('activity_status')->default(1)->comment('1:活動正常/2:活動停權');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_details');
    }
};
