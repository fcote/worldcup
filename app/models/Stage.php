<?php
/**
 * Modèle de donnée des étapes de la compétition
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

class Stage extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'stage';

    public $timestamps = false;

    /**
     * Récupère l'objet Stage suivant
     *
     * @var Stage
     */
    public function next_stage()
    {
        return $this->belongsTo('Stage', 'next_stage', 'id');
    }

    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'name' => 'required|alpha_num|max:255',
        /*'next_stage' => 'exists:stage,id',*/
    );

    public static function getThirdStage(){
        $nexts_id = array();
        foreach(Stage::select('next_stage')->where('next_stage', '<>', 'NULL')->get() as $value){
            $nexts_id[] = $value->next_stage;
        }

        $stage_third = Stage::whereNotIn('id',
            $nexts_id
        )->where('next_stage', null)->first();

        return $stage_third;
    }

    public static function getStartStage(){
        $nexts_id = array();
        foreach(Stage::select('next_stage')->where('next_stage', '<>', 'NULL')->get() as $value){
            $nexts_id[] = $value->next_stage;
        }

        $start_stage_id = Stage::whereNotIn('id',
            $nexts_id
        )->first();

        return $start_stage_id;
    }
}