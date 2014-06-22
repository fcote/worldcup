<?php
/**
 * Controlleur permetant la gestion des utilisateurs
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


class UserController extends BaseController {


    /**
     * Renvoi tout les utilisateurs en JSON
     *
     * @return Response
     */
    public function index()
    {
        return Response::json(
            array('success' => true,
                'payload' => User::get()->toArray(),
            ));
    }

    /**
     * Enregistre un nouvel utilisateur
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $validator = Validator::make($input, User::$rules);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $validator->messages()
                ),
                400);

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return Response::json(
            array('success' => true,
                'payload' => $user->toArray(),
            ));
    }

}