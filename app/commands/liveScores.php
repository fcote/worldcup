<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class liveScores extends Command {

    private $stage_assoc_api = array(
        "4" => "16",
        "3" => "17",
        "2" => "18",
        "1" => "19"
    );

    private function getApiRoundId($localId, $stage_game_num){
        if($localId == 1 && $stage_game_num == 1){
            return $this->stage_assoc_api[$localId] + 1;
        }else
            return $this->stage_assoc_api[$localId];
    }

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'liveScores';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Tache qui permet de récupérer les scores en direct depuis KimonoLabs.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		while(true){
            $date = new DateTime();
            $games = Game::whereRaw('date < ? && winner_id IS NULL', array(new DateTime("2014-06-28 20:26:20")))->get();

            if(count($games) > 0){

                foreach($games as $value){

                    $response = Unirest::get("http://live.mobileapp.fifa.com/api/wc/matches");

                    //On regarde tout les matchs de la liste retourné par l'API
                    /*foreach($response->body->games as $match){

                        //Si le match corespond a celui qu'on veut mettre à jour
                        if($match->team1_code == $value->team1()->get()->code && $match->team2_code == $value->team2()->get()->code){
                            //Si le match à commencé
                            if($match->score1 != "" && $match->score2 != ""){
                                //Si le match est en temps additionel (prolongation)
                                if($match->score1ot != "" && $match->score2ot != ""){
                                    $value->team1_goals = $match->score1ot;
                                    $value->team2_goals = $match->score2ot;
                                }else{
                                    $value->team1_goals = $match->score1;
                                    $value->team2_goals = $match->score2;
                                }

                                //Si but par penalties
                                if($match->score1p != "" && $match->score2p != ""){
                                    $value->team1_kick_at_goal = $match->score1p;
                                    $value->team2_kick_at_goal = $match->score2p;
                                }
                            }

                            break;
                        }
                    }

                    $value->save();*/

                    print_r($response);

                }

            }else
                $this->info('[' . $date->format('Y-m-d H:i:s') . '] Aucun match à surveiller.');


            sleep(50);
        }
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
        return array();
	}

}
