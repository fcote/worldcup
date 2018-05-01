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
        Team::create(array('name' => 'Russie', 'code' => 'RUS')); //1
        Team::create(array('name' => 'Arabie Saoudite', 'code' => 'KSA'));
        Team::create(array('name' => 'Egypte', 'code' => 'EGY'));
        Team::create(array('name' => 'Uruguay', 'code' => 'URU'));

        //Groupe B
        Team::create(array('name' => 'Portugal', 'code' => 'POR')); //5
        Team::create(array('name' => 'Espagne', 'code' => 'ESP'));
        Team::create(array('name' => 'Maroc', 'code' => 'MAR'));
        Team::create(array('name' => 'RI Iran', 'code' => 'IRN'));

        //Groupe C
        Team::create(array('name' => 'France', 'code' => 'FRA')); //9
        Team::create(array('name' => 'Australie', 'code' => 'AUS'));
        Team::create(array('name' => 'Pérou', 'code' => 'PER'));
        Team::create(array('name' => 'Danemark', 'code' => 'DEN'));

        //Groupe D
        Team::create(array('name' => 'Argentine', 'code' => 'ARG')); //13
        Team::create(array('name' => 'Islande', 'code' => 'ISL'));
        Team::create(array('name' => 'Croatie', 'code' => 'CRO'));
        Team::create(array('name' => 'Nigeria', 'code' => 'NGA'));


        //Groupe E
        Team::create(array('name' => 'Brésil', 'code' => 'BRA')); //17
        Team::create(array('name' => 'Suisse', 'code' => 'SUI'));
        Team::create(array('name' => 'Costa Rica', 'code' => 'CRC'));
        Team::create(array('name' => 'Serbie', 'code' => 'SRB'));

        //Groupe F
        Team::create(array('name' => 'Allemagne', 'code' => 'GER')); //21
        Team::create(array('name' => 'Mexique', 'code' => 'MEX'));
        Team::create(array('name' => 'Suède', 'code' => 'SWE'));
        Team::create(array('name' => 'République de Corée', 'code' => 'KOR'));

        //Groupe G
        Team::create(array('name' => 'Belgique', 'code' => 'BEL')); //25
        Team::create(array('name' => 'Panama', 'code' => 'PAN'));
        Team::create(array('name' => 'Tunisie', 'code' => 'TUN'));
        Team::create(array('name' => 'Angleterre', 'code' => 'ENG'));

        //Groupe H
        Team::create(array('name' => 'Pologne', 'code' => 'POL')); //29
        Team::create(array('name' => 'Sénégal', 'code' => 'SEN'));
        Team::create(array('name' => 'Colombie', 'code' => 'COL'));
        Team::create(array('name' => 'Japon', 'code' => 'JPN'));
    }

}

class StageTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stage')->delete();

        Stage::create(array('name' => 'Finale'));
        Stage::create(array('name' => '1/2 finales', 'next_stage' => 1));
        Stage::create(array('name' => '1/4 de finale', 'next_stage' => 2));
        Stage::create(array('name' => '1/8 de finale', 'next_stage' => 3));

        Stage::create(array('name' => '3e place'));
    }

}

class GameTableSeeder extends Seeder {

    public function run()
    {
        DB::table('game')->delete();

        //Pools
        Game::create(array('fifa_match_id' => 300331503, 'team1_id' => 1, 'team2_id' => 2, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-14T17:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300353632, 'team1_id' => 3, 'team2_id' => 4, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-15T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331526, 'team1_id' => 7, 'team2_id' => 8, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-15T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331524, 'team1_id' => 5, 'team2_id' => 6, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-15T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331533, 'team1_id' => 9, 'team2_id' => 10, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-16T12:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331515, 'team1_id' => 13, 'team2_id' => 14, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-16T15:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331528, 'team1_id' => 11, 'team2_id' => 12, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-16T18:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331523, 'team1_id' => 15, 'team2_id' => 16, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-16T21:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331529, 'team1_id' => 19, 'team2_id' => 20, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-17T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331502, 'team1_id' => 21, 'team2_id' => 22, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-17T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331525, 'team1_id' => 17, 'team2_id' => 18, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-17T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331499, 'team1_id' => 23, 'team2_id' => 24, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-18T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331539, 'team1_id' => 25, 'team2_id' => 26, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-18T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331554, 'team1_id' => 27, 'team2_id' => 28, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-18T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331550, 'team1_id' => 31, 'team2_id' => 32, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-19T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331545, 'team1_id' => 29, 'team2_id' => 30, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-19T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331495, 'team1_id' => 1, 'team2_id' => 3, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-19T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331511, 'team1_id' => 5, 'team2_id' => 7, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-20T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331530, 'team1_id' => 4, 'team2_id' => 2, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-20T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331496, 'team1_id' => 8, 'team2_id' => 6, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-20T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331518, 'team1_id' => 12, 'team2_id' => 10, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-21T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331527, 'team1_id' => 9, 'team2_id' => 11, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-21T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331513, 'team1_id' => 13, 'team2_id' => 15, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-21T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331540, 'team1_id' => 17, 'team2_id' => 19, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-22T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331497, 'team1_id' => 16, 'team2_id' => 14, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-22T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300340183, 'team1_id' => 20, 'team2_id' => 18, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-22T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331547, 'team1_id' => 25, 'team2_id' => 27, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-23T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331549, 'team1_id' => 24, 'team2_id' => 22, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-23T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331501, 'team1_id' => 21, 'team2_id' => 23, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-23T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331546, 'team1_id' => 28, 'team2_id' => 26, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-24T14:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331505, 'team1_id' => 32, 'team2_id' => 30, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-24T17:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331508, 'team1_id' => 29, 'team2_id' => 31, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-24T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331516, 'team1_id' => 4, 'team2_id' => 1, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-25T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331509, 'team1_id' => 2, 'team2_id' => 3, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-25T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300340184, 'team1_id' => 6, 'team2_id' => 7, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-25T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331500, 'team1_id' => 8, 'team2_id' => 5, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-25T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331512, 'team1_id' => 12, 'team2_id' => 9, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-26T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331506, 'team1_id' => 10, 'team2_id' => 11, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-26T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331510, 'team1_id' => 14, 'team2_id' => 15, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-26T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331519, 'team1_id' => 16, 'team2_id' => 13, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-26T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331548, 'team1_id' => 22, 'team2_id' => 23, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-27T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331532, 'team1_id' => 24, 'team2_id' => 21, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-27T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331521, 'team1_id' => 20, 'team2_id' => 17, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-27T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331534, 'team1_id' => 18, 'team2_id' => 19, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-27T20:00:00.000Z"))));

        Game::create(array('fifa_match_id' => 300331507, 'team1_id' => 32, 'team2_id' => 29, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-28T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331553, 'team1_id' => 30, 'team2_id' => 31, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-28T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300340182, 'team1_id' => 28, 'team2_id' => 25, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-28T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331520, 'team1_id' => 26, 'team2_id' => 27, 'date' => DateTime::createFromFormat("U", strtotime("2018-06-28T20:00:00.000Z"))));

        //8e
        Game::create(array('fifa_match_id' => 300331544, 'stage_id' => 4, 'team1_tmp_name' => '1A', 'team2_tmp_name' => '2B', 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2018-06-30T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331537, 'stage_id' => 4, 'team1_tmp_name' => '1C', 'team2_tmp_name' => '2D', 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', strtotime("2018-06-30T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331517, 'stage_id' => 4, 'team1_tmp_name' => '1B', 'team2_tmp_name' => '2A', 'stage_game_num' => 3, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-01T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331498, 'stage_id' => 4, 'team1_tmp_name' => '1D', 'team2_tmp_name' => '2C', 'stage_game_num' => 4, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-01T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331535, 'stage_id' => 4, 'team1_tmp_name' => '1E', 'team2_tmp_name' => '2F', 'stage_game_num' => 5, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-02T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331551, 'stage_id' => 4, 'team1_tmp_name' => '1G', 'team2_tmp_name' => '2H', 'stage_game_num' => 6, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-02T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331514, 'stage_id' => 4, 'team1_tmp_name' => '1F', 'team2_tmp_name' => '2E', 'stage_game_num' => 7, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-03T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331542, 'stage_id' => 4, 'team1_tmp_name' => '1H', 'team2_tmp_name' => '2G', 'stage_game_num' => 8, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-03T20:00:00.000Z"))));

        //Quarts
        Game::create(array('fifa_match_id' => 300331543, 'stage_id' => 3, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-06T16:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331504, 'stage_id' => 3, 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-07T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331538, 'stage_id' => 3, 'stage_game_num' => 3, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-06T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331541, 'stage_id' => 3, 'stage_game_num' => 4, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-07T16:00:00.000Z"))));

        //Demi
        Game::create(array('fifa_match_id' => 300331531, 'stage_id' => 2, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-10T20:00:00.000Z"))));
        Game::create(array('fifa_match_id' => 300331522, 'stage_id' => 2, 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-11T20:00:00.000Z"))));

        //Finale
        Game::create(array('fifa_match_id' => 300331552, 'stage_id' => 1, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-15T17:00:00.000Z"))));

        //Petite Finale
        Game::create(array('fifa_match_id' => 300331536, 'stage_id' => 5, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2018-07-14T16:00:00.000Z"))));

    }

}