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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->boolean('status')->default(1)->after('remember_token')->comment('0:停權/1:正常');
            $table->unsignedTinyInteger('user_role')->default(3)->after('remember_token')->comment('1:管理方/2:講師/3:學員');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('status');
        });
    }
};
