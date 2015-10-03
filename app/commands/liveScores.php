<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Unirest\Request;


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

                foreach($games as $value){
                    $response = Unirest\Request::get("http://cmsapi.pulselive.com/rugby/match/".$value->pulselive_match_id."/timeline?language=fr&client=pulse");

                    $body = $response->body;
                    $match = $body->match;
                    $teams = $match->teams;
                    $scores = $match->scores;

                    //Si le match corespond a celui qu'on veut mettre à jour
                    if(isset($teams[0]->abbreviation) && isset($teams[1]->abbreviation) && $teams[0]->abbreviation == $value->team1()->first()->code && $teams[1]->abbreviation == $value->team2()->first()->code){
                        //Si le match à commencé
                        if('U' !== $match->status && 'C' !== $match->status){
                            $value->team1_points = $scores[0];
                            $value->team2_points = $scores[1];

                            $this->info('[' . $date->format('Y-m-d H:i:s') . '] MAJ scores : '.$value->team1()->first()->name.' '.$value->team1_points.'-'.$value->team2_points.' '.$value->team2()->first()->name.'.');
                        }

                        if($match->status == 'C'){
                            if($value->team1_points > $value->team2_points){
                                $value->setFinished(1);
                                $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team1()->first()->name.' gagnant.');
                            }else if($value->team1_points < $value->team2_points){
                                $value->setFinished(2);
                                $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team2()->first()->name.' gagnant.');
                            }
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
