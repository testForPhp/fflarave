<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('pixel');
            $table->integer('sort')->index();
            $table->string('region');
            $table->tinyInteger('is_vip')->default(0);
            $table->integer('point')->default(0)->nullable();
            $table->string('time_limit')->default('')->nullable();
            $table->tinyInteger('is_banner')->default(0);
            $table->string('thumbnail');
            $table->string('link');
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
        Schema::dropIfExists('videos');
    }
}
