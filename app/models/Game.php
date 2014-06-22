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