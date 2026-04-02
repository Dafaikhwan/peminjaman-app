<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('log_aktivitas', function (Blueprint $table) {
        $table->string('nama_user')->nullable()->after('user_id');
    });
}

public function down()
{
    Schema::table('log_aktivitas', function (Blueprint $table) {
        $table->dropColumn('nama_user');
    });
}

};
