<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('summoner_id');
            $table->foreign('summoner_id')
                ->references('id')
                ->on('summoners')
                ->onDelete('cascade');
            $table->string('queue_type');
            $table->integer('wins');
            $table->integer('losses');
            $table->string('league_name');
            $table->string('tier');
            $table->string('rank');
            $table->integer('league_points');
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
        Schema::dropIfExists('leagues');
    }
}
