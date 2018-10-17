<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogoSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('systems', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('count');
            $table->string('ads_1')->nullable()->after('logo');
            $table->string('ads_1_link')->nullable()->after('ads_1');
            $table->string('ads_2')->nullable()->after('ads_1_link');
            $table->string('ads_2_link')->nullable()->after('ads_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('systems', function (Blueprint $table) {
            //
        });
    }
}
