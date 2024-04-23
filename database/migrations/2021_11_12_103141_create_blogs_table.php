<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0)->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->tinyInteger('comment');
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Published, 2 => Draft, 3 => Trash, 4 => Private, 5 => Pending');
            $table->enum('visibility', ['Pu', 'PP', 'Pr'])->comment('Pu => Public, PP => Password Protected, Pr => Private');
            $table->datetime('publish_on')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
