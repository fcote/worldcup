<?php
/**
 * Controlleur permetant la gestion des jeton d'accès à l'api
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

class AuthController extends BaseController {


    /**
     * Retourne un token si les informations sont bonnes
     *
     * @return mixed
     */
    public function login()
    {
        $input = Input::only('email', 'password');

        $user = User::getUserWithEmail($input['email']);

        if ($user != null && Input::has('email') && Input::has('password') && Hash::check($input['password'], $user->password))
        {
            return Response::json(
                array('success' => true,
                    'payload' => $user->getNewToken(),
                ));
        }else{
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => 'Informations incorrects (Adresse mail / mot de passe) !'
                ),
                404);
        }
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @return Redirect
     */
    public function logout()
    {
        DB::table('token')->where('id', '=', $_GET['token'])->delete();
        return Response::json(
            array('success' => true,
                'payload' => null,
            ));
    }
}