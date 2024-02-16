<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. 
     * up增加
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 在資料庫加開電話欄位
            $table->string('phone')->after('password')->nullable();

            // 在資料庫加開大頭貼欄位(圖片、聲音、影像 -> base64 -> 資料庫varchar / blob) (使用base64會把檔案變大，因此存放的檔案不可太大)
            // <img> 可使用 jpg 或 base64
            // blob 使用binary存入ascii code至資料庫 直接使用會成為亂碼
            $table->binary('image')->after('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations. 
     * down刪減
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 在資料庫刪減電話欄位
            $table->dropColumn('phone');
            // 在資料庫刪減大頭貼欄位
            $table->dropColumn('image');
        });
    }
};
