<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempPermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id');
            $table->string('name');
            $table->string('path');
            $table->string('controller')->nullable();
            $table->string('action')->nullable();
            $table->enum('type', ['App', 'Module', 'Controller', 'Action'])->default('App');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_permissions');
    }
}
