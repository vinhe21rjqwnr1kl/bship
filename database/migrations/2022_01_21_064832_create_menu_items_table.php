<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->unsignedBigInteger('menu_id');
            $table->bigInteger('item_id')->nullable()->default(0);
            $table->enum('type', ['Page','Link','Category','Post','Tag'])->comment('Page, Link, Category, Post, Tag');
            $table->string('title');
            $table->string('attribute')->nullable();
            $table->string('link')->nullable();
            $table->tinyInteger('menu_target')->nullable()->default(0);
            $table->text('css_classes')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('order')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
