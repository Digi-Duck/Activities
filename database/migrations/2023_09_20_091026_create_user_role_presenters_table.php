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
        Schema::create('user_role_presenters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->comment('帳號id');
            // user_id會對應到users的id欄位，並在users的id欄位被刪除時，user_id也會同時被刪除
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('user_name', 50)->comment('講師名稱');
            $table->string('img_path')->nullable()->default('')->comment('講師圖片路徑');
            $table->string('phone_number', 100)->comment('講師連絡電話');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_presenters');
    }
};
