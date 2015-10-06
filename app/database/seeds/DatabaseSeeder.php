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
        Team::create(array('name' => 'Wales', 'code' => 'WAL')); //1
        Team::create(array('name' => 'Autralie', 'code' => 'AUS'));
        Team::create(array('name' => 'Angleterre', 'code' => 'ENG'));
        Team::create(array('name' => 'Fiji', 'code' => 'FJI'));
        Team::create(array('name' => 'Uruguay', 'code' => 'URU'));

        //Groupe B
        Team::create(array('name' => 'Ecosse', 'code' => 'SCO')); //6
        Team::create(array('name' => 'Afrique du sud', 'code' => 'RSA'));
        Team::create(array('name' => 'Samoa', 'code' => 'SAM'));
        Team::create(array('name' => 'Japon', 'code' => 'JPN'));
        Team::create(array('name' => 'États-Unis', 'code' => 'USA'));

        //Groupe C
        Team::create(array('name' => 'Nouvelle Zélande', 'code' => 'NZL')); //11
        Team::create(array('name' => 'Tonga', 'code' => 'TGA'));
        Team::create(array('name' => 'Argentine', 'code' => 'ARG'));
        Team::create(array('name' => 'Géorgie', 'code' => 'GEO'));
        Team::create(array('name' => 'Namibie', 'code' => 'NAM'));

        //Groupe D
        Team::create(array('name' => 'France', 'code' => 'FRA')); //16
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

        //@TODO : problème sur les dates (prend pas en compte la timezone)

        //Pools
        Game::create(array('team1_id' => 3, 'team2_id' => 4, 'pulselive_match_id' => '14184', 'date' => DateTime::createFromFormat('U', 1442602800)));

        Game::create(array('team1_id' => 12, 'team2_id' => 14, 'pulselive_match_id' => '14206', 'date' => DateTime::createFromFormat('U', 1442660400)));
        Game::create(array('team1_id' => 17, 'team2_id' => 19, 'pulselive_match_id' => '14220', 'date' => DateTime::createFromFormat('U', 1442669400)));
        Game::create(array('team1_id' => 7, 'team2_id' => 9, 'pulselive_match_id' => '14194', 'date' => DateTime::createFromFormat('U', 1442677500)));
        Game::create(array('team1_id' => 16, 'team2_id' => 18, 'pulselive_match_id' => '14221', 'date' => DateTime::createFromFormat('U', 1442689200)));

        Game::create(array('team1_id' => 8, 'team2_id' => 10, 'pulselive_match_id' => '14195', 'date' => DateTime::createFromFormat('U', 1442746800)));
        Game::create(array('team1_id' => 1, 'team2_id' => 5, 'pulselive_match_id' => '14185', 'date' => DateTime::createFromFormat('U', 1442755800)));
        Game::create(array('team1_id' => 11, 'team2_id' => 13, 'pulselive_match_id' => '14208', 'date' => DateTime::createFromFormat('U', 1442763900)));

        Game::create(array('team1_id' => 6, 'team2_id' => 9, 'pulselive_match_id' => '14196', 'date' => DateTime::createFromFormat('U', 1443015000)));
        Game::create(array('team1_id' => 2, 'team2_id' => 4, 'pulselive_match_id' => '14186', 'date' => DateTime::createFromFormat('U', 1443023100)));
        Game::create(array('team1_id' => 16, 'team2_id' => 20, 'pulselive_match_id' => '14222', 'date' => DateTime::createFromFormat('U', 1443034800)));

        Game::create(array('team1_id' => 11, 'team2_id' => 15, 'pulselive_match_id' => '14209', 'date' => DateTime::createFromFormat('U', 1443121200)));

        Game::create(array('team1_id' => 13, 'team2_id' => 14, 'pulselive_match_id' => '14211', 'date' => DateTime::createFromFormat('U', 1443195900)));

        Game::create(array('team1_id' => 18, 'team2_id' => 19, 'pulselive_match_id' => '14224', 'date' => DateTime::createFromFormat('U', 1443274200)));
        Game::create(array('team1_id' => 7, 'team2_id' => 8, 'pulselive_match_id' => '14197', 'date' => DateTime::createFromFormat('U', 1443282300)));
        Game::create(array('team1_id' => 3, 'team2_id' => 1, 'pulselive_match_id' => '14187', 'date' => DateTime::createFromFormat('U', 1443294000)));

        Game::create(array('team1_id' => 2, 'team2_id' => 5, 'pulselive_match_id' => '14188', 'date' => DateTime::createFromFormat('U', 1443351600)));
        Game::create(array('team1_id' => 6, 'team2_id' => 10, 'pulselive_match_id' => '14198', 'date' => DateTime::createFromFormat('U', 1443360600)));
        Game::create(array('team1_id' => 17, 'team2_id' => 20, 'pulselive_match_id' => '14225', 'date' => DateTime::createFromFormat('U', 1443368700)));

        Game::create(array('team1_id' => 12, 'team2_id' => 15, 'pulselive_match_id' => '14212', 'date' => DateTime::createFromFormat('U', 1443541500)));

        Game::create(array('team1_id' => 1, 'team2_id' => 4, 'pulselive_match_id' => '14189', 'date' => DateTime::createFromFormat('U', 1443714300)));
        Game::create(array('team1_id' => 16, 'team2_id' => 19, 'pulselive_match_id' => '14227', 'date' => DateTime::createFromFormat('U', 1443726000)));

        Game::create(array('team1_id' => 11, 'team2_id' => 14, 'pulselive_match_id' => '14213', 'date' => DateTime::createFromFormat('U', 1443812400)));

        Game::create(array('team1_id' => 8, 'team2_id' => 9, 'pulselive_match_id' => '14200', 'date' => DateTime::createFromFormat('U', 1443879000)));
        Game::create(array('team1_id' => 7, 'team2_id' => 6, 'pulselive_match_id' => '14199', 'date' => DateTime::createFromFormat('U', 1443887100)));
        Game::create(array('team1_id' => 3, 'team2_id' => 2, 'pulselive_match_id' => '14190', 'date' => DateTime::createFromFormat('U', 1443898800)));

        Game::create(array('team1_id' => 13, 'team2_id' => 12, 'pulselive_match_id' => '14215', 'date' => DateTime::createFromFormat('U', 1443965400)));
        Game::create(array('team1_id' => 17, 'team2_id' => 18, 'pulselive_match_id' => '14228', 'date' => DateTime::createFromFormat('U', 1443973500)));

        Game::create(array('team1_id' => 19, 'team2_id' => 20, 'pulselive_match_id' => '14229', 'date' => DateTime::createFromFormat('U', 1444146300)));
        Game::create(array('team1_id' => 4, 'team2_id' => 5, 'pulselive_match_id' => '14191', 'date' => DateTime::createFromFormat('U', 1444158000)));

        Game::create(array('team1_id' => 7, 'team2_id' => 10, 'pulselive_match_id' => '14202', 'date' => DateTime::createFromFormat('U', 1444232700)));
        Game::create(array('team1_id' => 15, 'team2_id' => 14, 'pulselive_match_id' => '14216', 'date' => DateTime::createFromFormat('U', 1444244400)));

        Game::create(array('team1_id' => 11, 'team2_id' => 12, 'pulselive_match_id' => '14217', 'date' => DateTime::createFromFormat('U', 1444417200)));

        Game::create(array('team1_id' => 8, 'team2_id' => 6, 'pulselive_match_id' => '14203', 'date' => DateTime::createFromFormat('U', 1444483800)));
        Game::create(array('team1_id' => 2, 'team2_id' => 1, 'pulselive_match_id' => '14192', 'date' => DateTime::createFromFormat('U', 1444491900)));
        Game::create(array('team1_id' => 3, 'team2_id' => 5, 'pulselive_match_id' => '14193', 'date' => DateTime::createFromFormat('U', 1444503600)));

        Game::create(array('team1_id' => 13, 'team2_id' => 15, 'pulselive_match_id' => '14218', 'date' => DateTime::createFromFormat('U', 1444561200)));
        Game::create(array('team1_id' => 18, 'team2_id' => 20, 'pulselive_match_id' => '14231', 'date' => DateTime::createFromFormat('U', 1444570200)));
        Game::create(array('team1_id' => 16, 'team2_id' => 17, 'pulselive_match_id' => '14232', 'date' => DateTime::createFromFormat('U', 1444578300)));
        Game::create(array('team1_id' => 10, 'team2_id' => 9, 'pulselive_match_id' => '14205', 'date' => DateTime::createFromFormat('U', 1444590000)));

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