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
        'team1_goals',
        'team2_goals',
        'team1_kick_at_goal',
        'team2_kick_at_goal',
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
        $sumPoints = Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->sum('points');
        $sumBet = Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->count();

        if($sumPoints != 0)
            return $sumPoints/++$sumBet;
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
        $sumPoints = Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->sum('points');
        $sumBet = Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->count();

        if($sumPoints != 0)
            return $sumPoints/++$sumBet;
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

    public function setFinished($num_team){
        if($num_team == 1){
            $sumPoints = Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->sum('points');
            $sumBet = Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->count();
            $sumBet2 = Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->count();

            if($sumPoints != 0 && $sumBet != 0){
                foreach(Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->get() as $bet){
                    Transaction::addTransaction($bet->user_id, $bet->id, ($sumPoints/$sumBet) + $bet->points, 'gain');
                }
            }

            if($sumBet2 == 0){
                foreach(Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->get() as $bet){
                    Transaction::addTransaction($bet->user_id, $bet->id, $bet->points, 'gain');
                }
            }

            $this->winner_id = $this->team1_id;

        }else{

            $sumPoints = Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->sum('points');
            $sumBet = Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->count();
            $sumBet2 = Bet::whereRaw('game_id = ? && team1_goals > team2_goals', array($this->id))->count();

            if($sumPoints != 0 && $sumBet != 0){
                foreach(Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->get() as $bet){
                    Transaction::addTransaction($bet->user_id, $bet->id, ($sumPoints/$sumBet) + $bet->points, 'gain');
                }
            }

            if($sumBet2 == 0){
                foreach(Bet::whereRaw('game_id = ? && team1_goals < team2_goals', array($this->id))->get() as $bet){
                    Transaction::addTransaction($bet->user_id, $bet->id, $bet->points, 'gain');
                }
            }

            $this->winner_id = $this->team2_id;
        }

        $id = $this->stage()->first()->next_stage()->first()->id;
        $num_game = round($this->stage_game_num / 2);

        $game = Game::whereRaw("stage_id = ? && stage_game_num = ?", array($id, $num_game))->first();

        if(($this->stage_game_num % 2) == 1)
            $game->team1_id = $this->winner_id;
        else
            $game->team2_id = $this->winner_id;

        $game->save();
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