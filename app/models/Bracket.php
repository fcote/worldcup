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
        $start_stage_id = Stage::getStartStage()->id;

        $next_stage_id = $start_stage_id;

        while($next_stage_id){
            $games = array();

            $this->labels[] = Stage::find($next_stage_id)->name;

            $next_stage_id_tmp = Stage::find($next_stage_id)->next_stage;

            foreach(Game::whereRaw('stage_id = ?', array($next_stage_id))->orderBy('stage_game_num', 'ASC')->get() as $value){

                $score1 = $value->team1_goals;
                $score2 = $value->team2_goals;

                if($value->team1_kick_at_goal != null && $value->team2_kick_at_goal != null)
                    $score1 .= " (".$value->team1_kick_at_goal.")";
                if($value->team1_kick_at_goal != null && $value->team2_kick_at_goal != null)
                    $score2 .= " (".$value->team2_kick_at_goal.")";

                $games[] = array(
                    array('name' => ($value->team1()->first())?$value->team1()->first()->name:"-", 'id' => $value->team1_id, 'score' => $score1),
                    array('name' => ($value->team2()->first())?$value->team2()->first()->name:"-", 'id' => $value->team2_id, 'score' => $score2)
                );
            }

            $this->rounds[] = $games;

            if($next_stage_id_tmp == null){
                $gamme = Game::whereRaw('stage_id = ? && stage_game_num = 1', array($next_stage_id))->first();

                //Vinqueur
                $this->rounds[] = array( array(
                    array('name' => ($gamme->winner()->first())?$gamme->winner()->first()->name:"-", 'id' => $gamme->winner_id),
                ));
            }

            $next_stage_id = $next_stage_id_tmp;
        }

        /////////////////////////////////////////////////
        //******************* 3e place ****************//
        /////////////////////////////////////////////////
        $stage_third = Stage::getThirdStage()->id;

        $gamme_third = Game::whereRaw('stage_id = ?', array($stage_third))->first();

        if($gamme_third != null){
            $score1 = $value->team1_goals;
            $score2 = $value->team2_goals;

            if($gamme_third->team1_kick_at_goal != null && $gamme_third->team2_kick_at_goal != null)
                $score1 .= " (".$gamme_third->team1_kick_at_goal.")";
            if($gamme_third->team1_kick_at_goal != null && $gamme_third->team2_kick_at_goal != null)
                $score2 .= " (".$gamme_third->team2_kick_at_goal.")";

            $this->third[] = array( array(
                array('name' => ($gamme_third->team1()->first())?$gamme_third->team1()->first()->name:"-", 'id' => $gamme_third->team1_id, 'score' => $score2),
                array('name' => ($gamme_third->team2()->first())?$gamme_third->team2()->first()->name:"-", 'id' => $gamme_third->team2_id, 'score' => $score2)
            ));

            //Vinqueur 3e place
            $this->third[] = array( array(
                array('name' => ($gamme_third->winner()->first())?$gamme_third->winner()->first()->name:"-", 'id' => $gamme_third->winner_id),
            ));
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