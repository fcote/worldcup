<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TeamTableSeeder');
        $this->call('StageTableSeeder');
        $this->call('GameTableSeeder');
	}

}

class TeamTableSeeder extends Seeder {

    public function run()
    {
        DB::table('team')->delete();

        //Groupe A
        Team::create(array('name' => 'Brésil', 'code' => 'BRA'));
        Team::create(array('name' => 'Mexique', 'code' => 'MEX'));
        Team::create(array('name' => 'Croatie', 'code' => 'CRO'));
        Team::create(array('name' => 'Cameroun', 'code' => 'CMR'));

        //Groupe B
        Team::create(array('name' => 'Pays-Bas', 'code' => 'NED'));
        Team::create(array('name' => 'Chili', 'code' => 'CHI'));
        Team::create(array('name' => 'Australie', 'code' => 'AUS'));
        Team::create(array('name' => 'Espagne', 'code' => 'ESP'));

        //Groupe C
        Team::create(array('name' => 'Colombie', 'code' => 'COL'));
        Team::create(array('name' => 'Côte d\'ivoire', 'code' => 'CIV'));
        Team::create(array('name' => 'Japon', 'code' => 'JPN'));
        Team::create(array('name' => 'Grèce', 'code' => 'GRE'));

        //Groupe D
        Team::create(array('name' => 'Costa Rica', 'code' => 'CRC'));
        Team::create(array('name' => 'Italie', 'code' => 'ITA'));
        Team::create(array('name' => 'Uruguay', 'code' => 'URU'));
        Team::create(array('name' => 'Angleterre', 'code' => 'ENG'));

        //Groupe E
        Team::create(array('name' => 'France', 'code' => 'FRA'));
        Team::create(array('name' => 'Équateur', 'code' => 'ECU'));
        Team::create(array('name' => 'Suisse', 'code' => 'SUI'));
        Team::create(array('name' => 'Honduras', 'code' => 'HON'));

        //Groupe F
        Team::create(array('name' => 'Argentine', 'code' => 'ARG'));
        Team::create(array('name' => 'Nigeria', 'code' => 'NGA'));
        Team::create(array('name' => 'Iran', 'code' => 'IRN'));
        Team::create(array('name' => 'Bosnie-Herzégovine', 'code' => 'BIH'));

        //Groupe G
        Team::create(array('name' => 'Allemagne', 'code' => 'GER'));
        Team::create(array('name' => 'États-Unis', 'code' => 'USA'));
        Team::create(array('name' => 'Ghana', 'code' => 'GHA'));
        Team::create(array('name' => 'Portugal', 'code' => 'POR'));

        //Groupe H
        Team::create(array('name' => 'Belgique', 'code' => 'BEL'));
        Team::create(array('name' => 'Corée du Sud', 'code' => 'KOR'));
        Team::create(array('name' => 'Russie', 'code' => 'RUS'));
        Team::create(array('name' => 'Algérie', 'code' => 'ALG'));
    }

}

class StageTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stage')->delete();

        Stage::create(array('name' => 'Finale'));
        Stage::create(array('name' => '1/2 finale', 'next_stage' => 1));
        Stage::create(array('name' => '1/4 de finale', 'next_stage' => 2));
        Stage::create(array('name' => '1/8 de finale', 'next_stage' => 3));
    }

}

class GameTableSeeder extends Seeder {

    public function run()
    {
        DB::table('game')->delete();

        //8e
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1A', 'team2_tmp_name' => '2B', 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', 1403971200)));
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1C', 'team2_tmp_name' => '2D', 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', 1403985600)));
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1E', 'team2_tmp_name' => '2F', 'stage_game_num' => 3, 'date' => DateTime::createFromFormat('U', 1404144000)));
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1G', 'team2_tmp_name' => '2H', 'stage_game_num' => 4, 'date' => DateTime::createFromFormat('U', 1404158400)));
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1B', 'team2_tmp_name' => '2A', 'stage_game_num' => 5, 'date' => DateTime::createFromFormat('U', 1404057600)));
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1D', 'team2_tmp_name' => '2C', 'stage_game_num' => 6, 'date' => DateTime::createFromFormat('U', 1404072000)));
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1F', 'team2_tmp_name' => '2E', 'stage_game_num' => 7, 'date' => DateTime::createFromFormat('U', 1404230400)));
        Game::create(array('stage_id' => 4, 'team1_tmp_name' => '1H', 'team2_tmp_name' => '2G', 'stage_game_num' => 8, 'date' => DateTime::createFromFormat('U', 1404244800)));

        //Quarts
        Game::create(array('stage_id' => 3, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', 1404504000)));
        Game::create(array('stage_id' => 3, 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', 1404489600)));
        Game::create(array('stage_id' => 3, 'stage_game_num' => 3, 'date' => DateTime::createFromFormat('U', 1404576000)));
        Game::create(array('stage_id' => 3, 'stage_game_num' => 4, 'date' => DateTime::createFromFormat('U', 1404576000)));

        //Demi
        Game::create(array('stage_id' => 2, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', 1404849600)));
        Game::create(array('stage_id' => 2, 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', 1404936000)));


        //Finale
        Game::create(array('stage_id' => 1, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', 1405278000)));

        //Petite Finale
        Game::create(array('stage_id' => 1, 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', 1405195200)));

    }

}