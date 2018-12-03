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
            $table->string('summonerId');
            $table->foreign('summonerId')
                ->references('id')
                ->on('summoners')
                ->onDelete('cascade');
            $table->string('queueType');
            $table->integer('wins');
            $table->integer('losses');
            $table->string('leagueName');
            $table->string('tier');
            $table->string('rank');
            $table->integer('leaguePoints');
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
