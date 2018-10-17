<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramUserLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_user_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('program');
            $table->decimal('money',8,2)->default(0);
            $table->string('summary');
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
        Schema::dropIfExists('program_user_log');
    }
}
