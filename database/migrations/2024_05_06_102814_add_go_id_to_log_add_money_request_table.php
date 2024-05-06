<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_add_money_request', function (Blueprint $table) {
            $table->unsignedBigInteger('go_id')->after('user_id');;
            $table->foreign('go_id')->references('id')->on('go_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_add_money_request', function (Blueprint $table) {
            //
        });
    }
};
