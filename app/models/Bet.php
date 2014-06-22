<?php
/**
 * Modèle de donnée des paris
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

class Bet extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'bet';

    /**
     * Liste des champs assignable en masse
     *
     * @var array
     */
    protected $fillable = array('user_id', 'game_id', 'points', 'team1_goals', 'team2_goals');


    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('updated_at');

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'user_id' => 'exists:user,id',
        'game_id' => 'exists:game,id',
        'points' => 'required|integer',
        'team1_goals' => 'required|integer',
        'team2_goals' => 'required|integer',
    );
}