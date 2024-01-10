<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubTaskImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_task_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subtask_id');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('directory');

            $table->foreign('subtask_id')->references('id')->on('sub_tasks')->constrained()->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('sub_task_images');
    }
}
