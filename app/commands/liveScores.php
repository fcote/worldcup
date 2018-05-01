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
                    $response = Unirest\Request::get("https://data.fifa.com/matches/fr/live/info/".$value->fifa_match_id."");
                    $body = $response->body;
                    $match = $body->match;

                    //Si le match à commencé
                    if($match->isStarted && !$match->isFinished){
                        $value->team1_points = $match->scoreHome;
                        $value->team2_points = $match->scoreAway;
                        $value->team1_kick_at_goal = $match->scoreHomeFirstLeg;
                        $value->team2_kick_at_goal = $match->scoreAwayFirstLeg;
                        $value->minute = $match->minute;
                        $this->info('[' . $date->format('Y-m-d H:i:s') . '] MAJ scores : '.$value->team1()->first()->name.' '.$value->team1_points.'-'.$value->team2_points.' '.$value->team2()->first()->name.'.');
                    }

                    if($match->isStarted && $match->isFinished){
                        if($value->team1_goals > $value->team2_goals){
                            $value->setFinished(1);
                            $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team1()->first()->name.' gagnant.');
                        }else if($value->team1_goals < $value->team2_goals){
                            $value->setFinished(2);
                            $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team2()->first()->name.' gagnant.');
                        }else if($value->team1_goals == $value->team2_goals){
                            if($value->team1_kick_at_goal > $value->team2_kick_at_goal){
                                $value->setFinished(1);
                                $this->info('[' . $date->format('Y-m-d H:i:s') . '] Match fini : '.$value->team1()->first()->name.' gagnant.');
                            }else{
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
