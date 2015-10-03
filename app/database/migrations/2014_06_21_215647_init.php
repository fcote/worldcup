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
            $table->string('email', 255);
            $table->string('password', 255);
            $table->integer('points');
            $table->string('firstname', 255);
            $table->string('lastname', 255);

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
            $table->integer('stage_id')->unsigned();
            $table->integer('team1_points')->nullable();
            $table->integer('team2_points')->nullable();
            $table->string('team1_tmp_name', 255)->nullable();
            $table->string('team2_tmp_name', 255)->nullable();
            $table->integer('winner_id')->unsigned()->nullable();
            $table->integer('stage_game_num');
            $table->integer('pulselive_match_id');
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
            $table->integer('points');
            $table->enum('distance_points', array(
                BET::$DISTANCE_0_TO_5,
                BET::$DISTANCE_5_TO_10,
                BET::$DISTANCE_10_TO_15,
                BET::$DISTANCE_15_TO_20,
                BET::$DISTANCE_20_TO_25,
                BET::$DISTANCE_25_TO_30,
                BET::$DISTANCE_30_TO_35,
                BET::$DISTANCE_35_TO_40,
                BET::$DISTANCE_40_TO_45,
                BET::$DISTANCE_45_TO_50,
                BET::$DISTANCE_50_TO_55,
                BET::$DISTANCE_55_TO_60,
                BET::$DISTANCE_60_TO_65,
                BET::$DISTANCE_65_TO_70,
                BET::$DISTANCE_70_TO_75,
                BET::$DISTANCE_75_TO_80,
                BET::$DISTANCE_80_TO_85,
                BET::$DISTANCE_85_TO_90,
                BET::$DISTANCE_90_TO_95,
                BET::$DISTANCE_95_TO_100,
                BET::$DISTANCE_100_PLUS
            ));
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
            $table->enum('type', array('bet', 'gain'));

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
