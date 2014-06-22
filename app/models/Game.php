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
 * @version    0.1
 * @since      0.1
 */

class Game extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'game';


    public $timestamps = false;

    protected $attributes = array(
        'team1_cote' => 0,
        'team2_cote' => 0,
    );


    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('stage_game_num', 'stage_id', 'winner_id', 'team1_id', 'team2_id', 'created_at', 'updated_at');

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
        $sumPoints = Bet::whereRaw('team1_goals != NULL && team2_goals != NULL && game_id = ? && team1_goals < team2_goals', array($this->id))->sum('points');
        $sumBet = Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->count();

        if($sumPoints != 0 && $sumBet != 0)
            return $sumPoints/$sumBet;
        else
            return 0;
    }

    /**
     * Calcule la "cote" de l'équipe 2
     *
     * @var Integer
     */
    public function getTeam2CoteAttribute()
    {
        $sumPoints = Bet::whereRaw('team1_goals != NULL && team2_goals != NULL && game_id = ? && team1_goals > team2_goals', array($this->id))->sum('points');
        $sumBet = Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->count();

        if($sumPoints != 0 && $sumBet != 0)
            return $sumPoints/$sumBet;
        else
            return 0;
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

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'team1_id' => 'integer',
        'team2_id' => 'integer',
        'stage_id' => 'exists:stage,id',
        'team1_goals' => 'integer',
        'team2_goals' => 'integer',
        'team1_kick_at_goal' => 'integer',
        'team2_kick_at_goal' => 'integer',
        'team1_tmp_name' => 'alpha|max:255',
        'team2_tmp_name' => 'alpha|max:255',
        'winner_id' => 'integer',
        'stage_game_num' => 'integer',
        'date' => 'required|date',
    );
}