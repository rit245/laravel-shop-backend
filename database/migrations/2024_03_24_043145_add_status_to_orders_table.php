<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * orders 테이블에 status 컬럼 추가
     */
    public function up(): void
    {
//        Schema::table('orders', function (Blueprint $table) {
//            $table->string('status')->default('pending'); // 기본값은 'pending'으로 설정
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::table('orders', function (Blueprint $table) {
//            $table->dropColumn('status');
//        });
    }
};
