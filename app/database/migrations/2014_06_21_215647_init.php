<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //Création table des utilisateurs
        Schema::create('user', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('login', 255);
            $table->string('password', 255);

            $table->timestamps();
        });

        //Création table des utilisateurs
        Schema::create('token', function($table)
        {
            $table->string('id', 36);
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('user');

            $table->timestamps();
        });

        //Création table des équipes
        Schema::create('team', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 255);
            $table->string('code', 3);
        });


        //Création table des étapes de la compétition
        Schema::create('stage', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 255);
            $table->integer('next_stage')->unsigned()->nullable();

            $table->foreign('next_stage')->references('id')->on('stage');
        });

        //Création table des matches
        Schema::create('game', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('team1_id')->unsigned()->nullable();
            $table->integer('team2_id')->unsigned()->nullable();
            $table->integer('stage_id')->unsigned()->nullable();
            $table->integer('team1_points')->nullable();
            $table->integer('team2_points')->nullable();
            $table->integer('team1_kick_at_goal')->nullable();
            $table->integer('team2_kick_at_goal')->nullable();
            $table->string('team1_tmp_name', 255)->nullable();
            $table->string('team2_tmp_name', 255)->nullable();
            $table->integer('winner_id')->unsigned()->nullable();
            $table->integer('minute')->nullable();
            $table->integer('stage_game_num')->nullable();
            $table->integer('fifa_match_id');
            $table->timestamp('date');

            $table->foreign('team1_id')->references('id')->on('team');
            $table->foreign('team2_id')->references('id')->on('team');
            $table->foreign('stage_id')->references('id')->on('stage');
            $table->foreign('winner_id')->references('id')->on('team');
        });

        //Création table des paris
        Schema::create('bet', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->integer('team1_points');
            $table->integer('team2_points');
            $table->integer('winner_id')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('game_id')->references('id')->on('game');

            $table->timestamps();
        });

        //Création table des transactions
        Schema::create('transaction', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('bet_id')->unsigned();
            $table->integer('value');
            $table->enum('type', array('bet', 'gain', 'bonus'));

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('bet_id')->references('id')->on('bet');

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
        Schema::dropIfExists('transaction');
        Schema::dropIfExists('bet');
        Schema::dropIfExists('game');

        Schema::dropIfExists('token');
        Schema::dropIfExists('user');
        Schema::dropIfExists('team');
        Schema::dropIfExists('stage');
	}

}
