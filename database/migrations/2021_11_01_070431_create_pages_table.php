<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->unsignedBigInteger('user_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->enum('page_type', ['Page', 'Widget'])->nullable();
            $table->text('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->tinyInteger('comment');
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Published, 2 => Draft, 3 => Trash, 4 => Private, 5 => Pending');
            $table->enum('visibility', ['Pu', 'PP', 'Pr'])->comment('Pu => Public, PP => Password Protected, Pr => Private');
            $table->datetime('publish_on')->nullable();
            $table->bigInteger('order')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
