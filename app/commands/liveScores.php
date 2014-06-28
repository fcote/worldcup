<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class liveScores extends Command {

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
            $games = Game::whereRaw('date < ? && winner_id IS NULL', array(new DateTime()))->get();

            if(count($games) > 0){
                $response = Unirest::get("http://live.mobileapp.fifa.com/api/wc/matches");

                foreach($games as $value){

                    //On regarde tout les matchs de la liste retourné par l'API
                    foreach($response->body->data->second as $match){

                        //Si le match corespond a celui qu'on veut mettre à jour
                        if(isset($match->c_HomeNatioShort) && isset($match->c_AwayNatioShort) && $match->c_HomeNatioShort == $value->team1()->first()->code && $match->c_AwayNatioShort == $value->team2()->first()->code){
                            //Si le match à commencé
                            if($match->b_Started == true){
                                $value->team1_goals = $match->n_HomeGoals;
                                $value->team2_goals = $match->n_AwayGoals;

                                $this->info('[' . $date->format('Y-m-d H:i:s') . '] MAJ scores : '.$value->team1()->first()->name.' '.$value->team1_goals.'-'.$value->team2_goals.' '.$value->team2()->first()->name.'.');
                            }

                            if($match->b_Finished == true){
                                if($value->team1_goals > $value->team2_goals){
                                    $value->setFinished(1);
                                    $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team1()->first()->name.' gagnant.');
                                }else if($value->team1_goals < $value->team2_goals){
                                    $value->setFinished(2);
                                    $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team2()->first()->name.' gagnant.');
                                }else if($value->team1_goals == $value->team2_goals){

                                    $value->team1_kick_at_goal = $match->n_HomeGoalsShootout;
                                    $value->team2_kick_at_goal = $match->n_AwayGoalsShootout;

                                    if($match->n_HomeGoalsShootout > $match->n_AwayGoalsShootout){
                                        $value->setFinished(1);
                                        $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team1()->first()->name.' gagnant.');
                                    }else{
                                        $value->setFinished(2);
                                        $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team2()->first()->name.' gagnant.');
                                    }
                                }
                            }

                            break;
                        }
                    }

                    $value->save();
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
