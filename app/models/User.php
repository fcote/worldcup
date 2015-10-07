<?php
/**
 * Modèle de donnée des utilisateurs
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

use Rhumsaa\Uuid\Uuid;

class User extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * Liste des champs assignable en masse
     *
     * @var array
     */
    protected $fillable = array('login', 'password');

    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Liste des champs qui peuvent servir de filter dans l'url
     *
     * @var array
     */
    public $filters = array('login',
        'points');

    public function toArray()
    {
        $array = parent::toArray();
        $array['winPoints'] = $this->winPoints;
        return $array;
    }

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'login' => 'required|max:255',
        'password' => 'required|max:255',
        /*'points' => 'required|integer',*/
    );

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql pour la mise à jour
     *
     * @var array
     */
    public static $rulesUpdate = array(
        'login' => 'max:255',
        'password' => 'max:255',
    );

    /**
     * Méthode pour récupérer un objet utilisateur avec un email
     * @param $email
     * @param $password
     * @return mixed
     */
    public static function getUserWithLogin($login){
        return User::where('login', $login)->first();
    }

    /**
     * Méthode pour récupérer un object utilisateur avec un jeton d'accès
     * @param $token
     * @return mixed
     */
    public static function getUserWithToken($token){
        return User::join('token', 'token.user_id', '=', 'user.id')
            ->select('user.*')
            ->where('token.id', $token)
            ->first();
    }

    public function getWinPointsAttribute()
    {
        return DB::table('transaction')->where('user_id', '=', $this->id)->where(function($req){$req->where('type', '=', 'gain')->orWhere('type', '=', 'bonus');})->sum('value');
    }

    /**
     * Créer un nouveau jeton d'accès
     * @return Token
     */
    public function getNewToken(){
        $id = (string)Uuid::uuid4();

        $token = new Token();
        $token->id = $id;
        $token->user_id = $this->id;
        $token->save();
        $token->id = $id;

        return $token;
    }
}