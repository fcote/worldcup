<?php
/**
 * Modèle de donnée de l'arbre
 *
 * PHP version 5.5
 *
 * @category   Modèles
 * @package    worldcup\app\models
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    0.1
 * @since      0.1
 */

class Bracket extends Eloquent {

    private $teams = array();
    private $result = array();

    private function setTeams(){

        $nexts_id = array();
        foreach(Stage::select('next_stage')->where('next_stage', '<>', 'NULL')->get() as $value){
            $nexts_id[] = $value->next_stage;
        }

        $stage_id = Stage::whereNotIn('id',
            $nexts_id
        )->first()->id;

        foreach(Game::whereRaw('stage_id = ?', array($stage_id))->orderBy('stage_game_num', 'ASC')->get() as $value){

            $team1 = array(
                "name" => ($value->team1()->first() != null)?$value->team1()->first()->name:"",
                "flag" => ($value->team1()->first() != null)?$value->team1()->first()->code:"",
                "tmp" => $value->team1_tmp_name
            );

            $team2 = array(
                "name" => ($value->team2()->first() != null)?$value->team2()->first()->name:"",
                "flag" => ($value->team2()->first() != null)?$value->team2()->first()->code:"",
                "tmp" => $value->team2_tmp_name
            );

            $this->teams[] = array($team1, $team2);
        }
    }

    private function setResults(){
        $nexts_id = array();
        foreach(Stage::select('next_stage')->where('next_stage', '<>', 'NULL')->get() as $value){
            $nexts_id[] = $value->next_stage;
        }

        $start_stage_id = Stage::whereNotIn('id',
            $nexts_id
        )->first()->id;

        $next_stage_id = $start_stage_id;

        while($next_stage_id){
            $games = array();

            foreach(Game::whereRaw('stage_id = ?', array($next_stage_id))->orderBy('stage_game_num', 'ASC')->get() as $value){
                if($value->winner_id != null){
                    if($value->team1_kick_at_goal != null && $value->team2_kick_at_goal != null)
                        $games[] = array($value->team1_goals+$value->team1_kick_at_goal, $value->team2_goals+$value->team2_kick_at_goal);
                    else
                        $games[] = array($value->team1_goals, $value->team2_goals);
                }
                    $gammes[] = array(null, null);
            }

            $next_stage_id = Stage::find($next_stage_id)->next_stage;
            $this->result[] = $games;
        }
    }

    public function getArray(){
        $this->setTeams();
        $this->setResults();

        return array(
            "teams" => $this->teams,
            "results" => $this->result
        );
    }
}