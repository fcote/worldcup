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
 * @version    0.1
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
    protected $fillable = array('email', 'password', 'firstname', 'lastname');

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
    public $filters = array('email',
        'firstname',
        'lastname',
        'points');

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'email' => 'required|email|max:255',
        'password' => 'required|max:255',
        /*'points' => 'required|integer',*/
        'firstname' => 'required|alpha_num|max:255',
        'lastname' => 'required|alpha_num|max:255',
    );

    /**
     * Méthode pour récupérer un objet utilisateur avec un email
     * @param $email
     * @param $password
     * @return mixed
     */
    public static function getUserWithEmail($email){
        return User::where('email', $email)->first();
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