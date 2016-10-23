<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryRetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_retail', function (Blueprint $table) {
            $table->unsignedInteger('history_id');
            $table->unsignedInteger('retail_id');

            $table->foreign('history_id')->references('id')->on('histories')->onDelete('cascade');
            $table->foreign('retail_id')->references('id')->on('retails')->onDelete('cascade');

            $table->primary(['history_id', 'retail_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
