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

    private $rounds = array();
    private $third = array();
    private $labels = array();

    private function setRound(){
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

            $this->labels[] = Stage::find($next_stage_id)->name;

            $next_stage_id_tmp = Stage::find($next_stage_id)->next_stage;

            foreach(Game::whereRaw('stage_id = ?', array($next_stage_id))->orderBy('stage_game_num', 'ASC')->get() as $value){

                $name1 = ($value->team1()->first())?$value->team1()->first()->name:"-";
                $name2 = ($value->team2()->first())?$value->team2()->first()->name:"-";
                $id1 = $value->team1_id;
                $id2 = $value->team2_id;
                $score1 = $value->team1_goals;
                $score2 = $value->team2_goals;

                if($value->team1_kick_at_goal != null && $value->team2_kick_at_goal != null)
                    $score1 .= " (".$value->team1_kick_at_goal.")";
                if($value->team1_kick_at_goal != null && $value->team2_kick_at_goal != null)
                    $score2 .= " (".$value->team2_kick_at_goal.")";

                if($next_stage_id_tmp == null && $value->stage_game_num == 2){
                    $this->third[] = array( array(
                        array('name' => $name1, 'id' => $id1, 'score' => $score1),
                        array('name' => $name2, 'id' => $id2, 'score' => $score2)
                    ));
                }else{
                    $games[] = array(
                        array('name' => $name1, 'id' => $id1, 'score' => $score1),
                        array('name' => $name2, 'id' => $id2, 'score' => $score2)
                    );
                }
            }

            $this->rounds[] = $games;

            if($next_stage_id_tmp == null){
                $gamme = Game::whereRaw('stage_id = ? && stage_game_num = 1', array($next_stage_id))->first();

                //Vinqueur
                $this->rounds[] = array( array(
                    array('name' => ($gamme->winner()->first())?$gamme->winner()->first()->name:"-", 'id' => $gamme->winner_id),
                ));

                $gammeLooser = Game::whereRaw('stage_id = ? && stage_game_num = 2', array($next_stage_id))->first();

                //Vinqueur
                $this->third[] = array( array(
                    array('name' => ($gammeLooser->winner()->first())?$gammeLooser->winner()->first()->name:"-", 'id' => $gammeLooser->winner_id),
                ));
            }

            $next_stage_id = $next_stage_id_tmp;
        }
    }

    public function getArray(){
        $this->setRound();

        return array(
            'rounds' => $this->rounds,
            'third' => $this->third,
            'labels' => $this->labels
        );
    }

}