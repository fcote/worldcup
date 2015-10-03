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
        Team::create(array('name' => 'Wales', 'code' => 'WAL'));
        Team::create(array('name' => 'Autralie', 'code' => 'AUS'));
        Team::create(array('name' => 'Angleterre', 'code' => 'ENG'));
        Team::create(array('name' => 'Fiji', 'code' => 'FJI'));
        Team::create(array('name' => 'Uruguay', 'code' => 'URU'));

        //Groupe B
        Team::create(array('name' => 'Ecosse', 'code' => 'SCO'));
        Team::create(array('name' => 'Afrique du sud', 'code' => 'RSA'));
        Team::create(array('name' => 'Samoa', 'code' => 'SAM'));
        Team::create(array('name' => 'Japon', 'code' => 'JPN'));
        Team::create(array('name' => 'États-Unis', 'code' => 'USA'));

        //Groupe C
        Team::create(array('name' => 'Nouvelle Zélande', 'code' => 'NZL'));
        Team::create(array('name' => 'Tonga', 'code' => 'TGA'));
        Team::create(array('name' => 'Argentine', 'code' => 'ARG'));
        Team::create(array('name' => 'Géorgie', 'code' => 'GEO'));
        Team::create(array('name' => 'Namibie', 'code' => 'NAM'));

        //Groupe D
        Team::create(array('name' => 'France', 'code' => 'FRA'));
        Team::create(array('name' => 'Irlande', 'code' => 'IRE'));
        Team::create(array('name' => 'Italie', 'code' => 'ITA'));
        Team::create(array('name' => 'Canada', 'code' => 'CAN'));
        Team::create(array('name' => 'Roumanie', 'code' => 'ROM'));
    }

}

class StageTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stage')->delete();

        Stage::create(array('name' => 'Finale'));
        Stage::create(array('name' => '1/2 finales', 'next_stage' => 1));
        Stage::create(array('name' => '1/4 de finale', 'next_stage' => 2));

        Stage::create(array('name' => '3e place'));
    }

}

class GameTableSeeder extends Seeder {

    public function run()
    {
        DB::table('game')->delete();

        //Quarts
        Game::create(array('stage_id' => 3, 'team1_tmp_name' => '1B', 'team2_tmp_name' => '2A', 'stage_game_num' => 1, 'pulselive_match_id' => '14226', 'date' => DateTime::createFromFormat('U', 1445094000)));
        Game::create(array('stage_id' => 3, 'team1_tmp_name' => '1C', 'team2_tmp_name' => '2D', 'stage_game_num' => 2, 'pulselive_match_id' => '14230', 'date' => DateTime::createFromFormat('U', 1445108400)));
        Game::create(array('stage_id' => 3, 'team1_tmp_name' => '1D', 'team2_tmp_name' => '2C', 'stage_game_num' => 3, 'pulselive_match_id' => '13223', 'date' => DateTime::createFromFormat('U', 1445169600)));
        Game::create(array('stage_id' => 3, 'team1_tmp_name' => '1A', 'team2_tmp_name' => '2B', 'stage_game_num' => 4, 'pulselive_match_id' => '14219', 'date' => DateTime::createFromFormat('U', 1445180400)));

        //Demi
        Game::create(array('stage_id' => 2, 'stage_game_num' => 1, 'pulselive_match_id' => '14214', 'date' => DateTime::createFromFormat('U', 1445698800)));
        Game::create(array('stage_id' => 2, 'stage_game_num' => 2, 'pulselive_match_id' => '14210', 'date' => DateTime::createFromFormat('U', 1445788800)));


        //Finale
        Game::create(array('stage_id' => 1, 'stage_game_num' => 1, 'pulselive_match_id' => '14204', 'date' => DateTime::createFromFormat('U', 1446307200)));

        //Petite Finale
        Game::create(array('stage_id' => 4, 'stage_game_num' => 1, 'pulselive_match_id' => '14201', 'date' => DateTime::createFromFormat('U', 1446235200)));

    }

}