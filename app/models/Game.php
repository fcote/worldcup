<?php
/**
 * Modèle de donnée des matchs
 *
 * PHP version 5.5
 *
 * @category   Modèles
 * @package    worldcup\app\models
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
 * @since      0.1
 */

class Game extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'game';

    private $MAX_COTE = 10;
    private $MIN_COTE = 1.10;


    public $timestamps = false;


    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('stage_game_num', 'created_at', 'updated_at');

    /**
     * Liste des champs qui peuvent servir de filter dans l'url
     *
     * @var array
     */
    public $filters = array('team1_id',
        'team2_id',
        'stage_id',
        'team1_points',
        'team2_points',
        'team1_tmp_name',
        'team2_tmp_name',
        'winner_id',
        'stage_game_num',
        'date');

    /**
     * Tableau indiquant les sous élements à imbriquer
     *
     * @var array
     */
    protected $with = array('stage', 'team1', 'team2', 'winner');

    /**
     * Récupère l'objet Stage indiqué dans ce matche
     *
     * @var Stage
     */
    public function stage()
    {
        return $this->belongsTo('Stage', 'stage_id', 'id');
    }

    /**
     * Récupère l'objet Team indiqué comme équipe numéro une
     *
     * @var Stage
     */
    public function team1()
    {
        return $this->belongsTo('Team', 'team1_id', 'id');
    }

    /**
     * Récupère l'objet Team indiqué comme équipe numéro deux
     *
     * @var Stage
     */
    public function team2()
    {
        return $this->belongsTo('Team', 'team2_id', 'id');
    }

    /**
     * Récupère l'objet Team indiqué comme gagnante
     *
     * @var Stage
     */
    public function winner()
    {
        return $this->belongsTo('Team', 'winner_id', 'id');
    }

    /**
     * Calcule la "cote" de l'équipe 1
     *
     * @var Integer
     */
    public function getTeam1CoteAttribute()
    {
        $sumPoints1 = Bet::whereRaw('game_id = ? && winner_id = ?', array($this->id, $this->team1_id))->sum('points');
        $sumPoints2 = Bet::whereRaw('game_id = ? && winner_id = ?', array($this->id, $this->team2_id))->sum('points');

        $cote = ((($sumPoints2+1)/($sumPoints1+1))+1);

        $cote = round($cote, 2);

        if($cote > $this->MAX_COTE)
            $cote = $this->MAX_COTE;

        if($cote < $this->MIN_COTE)
            $cote = $this->MIN_COTE;

        return $cote;
    }


    public function getUserHasBetAttribute()
    {
        $user = User::getUserWithToken($_GET['token']);
        $bet = Bet::whereRaw('game_id = ? && user_id = ?', array($this->id, $user->id))->first();

        if($bet)
            return true;
        else
            return false;
    }

    /**
     * Calcule la "cote" de l'équipe 2
     *
     * @var Integer
     */
    public function getTeam2CoteAttribute()
    {
        $sumPoints1 = Bet::whereRaw('game_id = ? && winner_id = ?', array($this->id, $this->team1_id))->sum('points');
        $sumPoints2 = Bet::whereRaw('game_id = ? && winner_id = ?', array($this->id, $this->team2_id))->sum('points');

        $cote = ((($sumPoints1+1)/($sumPoints2+1))+1);
        $cote = round($cote,2);

        if($cote > $this->MAX_COTE)
            $cote = $this->MAX_COTE;

        if($cote < $this->MIN_COTE)
            $cote = $this->MIN_COTE;

        return $cote;
    }

    public function toArray()
    {
        $array = parent::toArray();
        foreach ($this->getMutatedAttributes() as $key)
        {
            if ( ! array_key_exists($key, $array)) {
                $array[$key] = $this->{$key};
            }
        }
        return $array;
    }

    public function setFinished($num_team){

        //Si l'équipe une a gagnée, on redistribue les points pour les paris corrects (paris sur l'équipe une)
        if($num_team == 1){
            foreach(Bet::whereRaw('game_id = ? && winner_id = ?', array($this->id, $this->team1_id))->get() as $bet){

                $cote = $this->getTeam1CoteAttribute();
                $points = $bet->points * $cote;

                if($bet->inDistance($this->team1_points-$this->team2_points))
                    $points += (($bet->points/10)*$cote);

                Transaction::addTransaction($bet->user_id, $bet->id, $points, 'gain');
            }

            $this->winner_id = $this->team1_id;

        //Si l'équipe deux a gagnée, on redistribue les points pour les paris corrects (paris sur l'équipe deux)
        }else{
            foreach(Bet::whereRaw('game_id = ? && winner_id = ?', array($this->id, $this->team2_id))->get() as $bet){

                $cote = $this->getTeam2CoteAttribute();
                $points = $bet->points * $cote;

                if($bet->inDistance($this->team2_points-$this->team1_points))
                    $points += (($bet->points/10)*$cote);

                Transaction::addTransaction($bet->user_id, $bet->id, $points, 'gain');
            }

            $this->winner_id = $this->team2_id;
        }

        /////////////////////////////////////////////////
        //******************* ROUND X *****************//
        /////////////////////////////////////////////////

        //On inscrit l'équipe gagnante dans son prochain match
        $id = $this->stage()->first()->next_stage()->first()->id;
        $num_game = round($this->stage_game_num / 2);

        $game = Game::whereRaw("stage_id = ? && stage_game_num = ?", array($id, $num_game))->first();

        if(($this->stage_game_num % 2) == 1)
            $game->team1_id = $this->winner_id;
        else
            $game->team2_id = $this->winner_id;

        $game->save();

        /////////////////////////////////////////////////
        //******************* 3e place ****************//
        /////////////////////////////////////////////////

        //Si on est lors des demi, on va définir aussi la 3e finale
        if($this->stage()->first()->next_stage()->first()->next_stage == null){

            $stage_third = Stage::getThirdStage()->id;

            $gamme_third = Game::whereRaw('stage_id = ?', array($stage_third))->first();

            //Si équipe 1 a gagné on met l'équipe 2 en 3e place
            if($num_game == 1){
                if(($this->stage_game_num % 2) == 1)
                    $gamme_third->team1_id = $this->team1_id;
                else
                    $gamme_third->team2_id = $this->team1_id;
            }else{
                if(($this->stage_game_num % 2) == 1)
                    $gamme_third->team1_id = $this->team2_id;
                else
                    $gamme_third->team2_id = $this->team2_id;
            }

            $gamme_third->save();
        }

        $this->save();
    }

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'team1_id' => 'integer',
        'team2_id' => 'integer',
        'stage_id' => 'exists:stage,id',
        'team1_points' => 'integer',
        'team2_points' => 'integer',
        'team1_tmp_name' => 'alpha|max:255',
        'team2_tmp_name' => 'alpha|max:255',
        'winner_id' => 'integer',
        'stage_game_num' => 'integer',
        'date' => 'required|date',
    );
}