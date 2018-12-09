<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('platform_id');
            $table->string('account_id');
            $table->foreign('account_id')
                ->references('account_id')
                ->on('summoners')
                ->onDelete('cascade');
            $table->integer('champion_id');
            $table->integer('queue');
            $table->integer('season');
            $table->string('lane');
            $table->timestamp('started_at');
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
        Schema::dropIfExists('matches');
    }
}
