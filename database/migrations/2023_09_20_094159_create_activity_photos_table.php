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
        Schema::create('activity_photos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('activity_id')->comment('活動id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('activity_id')->references('id')->on('activity_details')->onDelete('cascade');
            $table->string('activity_img_path')->comment('活動照片路徑');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_photos');
    }
};
