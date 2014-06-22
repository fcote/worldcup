<?php
/**
 * Modèle de donnée des transactions
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

class Transaction extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'transaction';

    /**
     * Tableau indiquant les sous élements à imbriquer
     *
     * @var array
     */
    protected $with = array('bet');

    /**
     * Récupère l'objet Bet indiqué dans cette transaction
     *
     * @var Stage
     */
    public function bet()
    {
        return $this->belongsTo('Bet', 'bet_id', 'id');
    }

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'user_id' => 'exists:stage,id',
        'bet_id' => 'exists:bet,id',
        'value' => 'integer',
        'type' => 'in:bet,gain',
    );
}