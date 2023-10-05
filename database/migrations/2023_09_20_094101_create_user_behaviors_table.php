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
        Schema::create('user_behaviors', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type_id')->comment('1:presenter(create_activity_id)/2:student(register_activity_id)');
            $table->string('behavior')->comment('1:講師活動建立/2:講師活動取消/3:講師活動編輯/4:學員活動報名/5:學員取消報名/6:學員編輯報名');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_behaviors');
    }
};
