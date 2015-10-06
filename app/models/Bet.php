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
 * @version    1.0
 * @since      0.1
 */

class Bet extends Eloquent {

    static $DISTANCE_0_TO_5 = '0-5';
    static $DISTANCE_5_TO_10 = '5-10';
    static $DISTANCE_10_TO_15 = '10-15';
    static $DISTANCE_15_TO_20 = '15-20';
    static $DISTANCE_20_TO_25 = '20-25';
    static $DISTANCE_25_TO_30 = '25-30';
    static $DISTANCE_30_TO_35 = '30-35';
    static $DISTANCE_35_TO_40 = '35-40';
    static $DISTANCE_40_TO_45 = '40-45';
    static $DISTANCE_45_TO_50 = '45-50';
    static $DISTANCE_50_TO_55 = '50-55';
    static $DISTANCE_55_TO_60 = '55-60';
    static $DISTANCE_60_TO_65 = '60-65';
    static $DISTANCE_65_TO_70 = '65-70';
    static $DISTANCE_70_TO_75 = '70-75';
    static $DISTANCE_75_TO_80 = '75-80';
    static $DISTANCE_80_TO_85 = '80-85';
    static $DISTANCE_85_TO_90 = '85-90';
    static $DISTANCE_90_TO_95 = '99-95';
    static $DISTANCE_95_TO_100 = '95-100';
    static $DISTANCE_100_PLUS = '100+';

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'bet';

    /**
     * Tableau indiquant les sous élements à imbriquer
     *
     * @var array
     */
    protected $with = array('user');

    /**
     * Liste des champs assignable en masse
     *
     * @var array
     */
    protected $fillable = array('user_id', 'game_id', 'points', 'distance_points', 'winner_id');

    /**
     * Liste des champs qui peuvent servir de filter dans l'url
     *
     * @var array
     */
    public $filters = array('game_id', 'user_id', 'points', 'distance_points');

    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('updated_at');

    /**
     * Récupère l'objet Match indiqué
     *
     * @var Stage
     */
    public function game()
    {
        return $this->belongsTo('Game', 'game_id', 'id');
    }

    /**
     * Récupère l'objet User
     *
     * @var Stage
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }

    public function inDistance($points){
        switch ($this->distance_points) {
            case BET::$DISTANCE_0_TO_5:
                return ($points > 0 && $points <= 5);
            case BET::$DISTANCE_5_TO_10:
                return ($points > 5 && $points <= 10);
            case BET::$DISTANCE_10_TO_15:
                return ($points > 10 && $points <= 15);
            case BET::$DISTANCE_15_TO_20:
                return ($points > 15 && $points <= 20);
            case BET::$DISTANCE_20_TO_25:
                return ($points > 20 && $points <= 25);
            case BET::$DISTANCE_25_TO_30:
                return ($points > 25 && $points <= 30);
            case BET::$DISTANCE_30_TO_35:
                return ($points > 30 && $points <= 35);
            case BET::$DISTANCE_35_TO_40:
                return ($points > 35 && $points <= 40);
            case BET::$DISTANCE_40_TO_45:
                return ($points > 40 && $points <= 45);
            case BET::$DISTANCE_45_TO_50:
                return ($points > 45 && $points <= 50);
            case BET::$DISTANCE_50_TO_55:
                return ($points > 50 && $points <= 55);
            case BET::$DISTANCE_55_TO_60:
                return ($points > 55 && $points <= 60);
            case BET::$DISTANCE_60_TO_65:
                return ($points > 60 && $points <= 65);
            case BET::$DISTANCE_65_TO_70:
                return ($points > 65 && $points <= 70);
            case BET::$DISTANCE_70_TO_75:
                return ($points > 70 && $points <= 75);
            case BET::$DISTANCE_75_TO_80:
                return ($points > 75 && $points <= 80);
            case BET::$DISTANCE_80_TO_85:
                return ($points > 80 && $points <= 85);
            case BET::$DISTANCE_85_TO_90:
                return ($points > 85 && $points <= 90);
            case BET::$DISTANCE_90_TO_95:
                return ($points > 90 && $points <= 95);
            case BET::$DISTANCE_95_TO_100:
                return ($points > 95 && $points <= 100);
            case BET::$DISTANCE_100_PLUS:
                return ($points > 100);
        }
    }

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'user_id' => 'exists:user,id',
        'game_id' => 'exists:game,id',
        'points' => 'required|integer',
        'distance_points' => 'required',
        'winner_id' => 'required|exists:team,id',
    );

    /**
     * Retrourne les différentes distances possible
     *
     * @return array
     */
    public static function getDistances(){
        return array(
            array('id' => BET::$DISTANCE_0_TO_5, 'name' => '1 à 5'),
            array('id' => BET::$DISTANCE_5_TO_10, 'name' => '6 à 10'),
            array('id' => BET::$DISTANCE_10_TO_15, 'name' => '11 à 15'),
            array('id' => BET::$DISTANCE_15_TO_20, 'name' => '16 à 20'),
            array('id' => BET::$DISTANCE_20_TO_25, 'name' => '21 à 25'),
            array('id' => BET::$DISTANCE_25_TO_30, 'name' => '26 à 30'),
            array('id' => BET::$DISTANCE_30_TO_35, 'name' => '31 à 35'),
            array('id' => BET::$DISTANCE_35_TO_40, 'name' => '36 à 40'),
            array('id' => BET::$DISTANCE_40_TO_45, 'name' => '41 à 45'),
            array('id' => BET::$DISTANCE_45_TO_50, 'name' => '46 à 50'),
            array('id' => BET::$DISTANCE_50_TO_55, 'name' => '51 à 55'),
            array('id' => BET::$DISTANCE_55_TO_60, 'name' => '56 à 60'),
            array('id' => BET::$DISTANCE_60_TO_65, 'name' => '61 à 65'),
            array('id' => BET::$DISTANCE_65_TO_70, 'name' => '66 à 70'),
            array('id' => BET::$DISTANCE_70_TO_75, 'name' => '71 à 75'),
            array('id' => BET::$DISTANCE_75_TO_80, 'name' => '76 à 80'),
            array('id' => BET::$DISTANCE_80_TO_85, 'name' => '81 à 85'),
            array('id' => BET::$DISTANCE_85_TO_90, 'name' => '86 à 90'),
            array('id' => BET::$DISTANCE_90_TO_95, 'name' => '91 à 95'),
            array('id' => BET::$DISTANCE_95_TO_100, 'name' => '96 à 10'),
            array('id' => BET::$DISTANCE_100_PLUS, 'name' => '101+'),
        );
    }
}