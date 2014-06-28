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
                'payload' => $this->query_params(new User())->toArray(),
            ));
    }

    /**
     * Renvoi un utilisateur
     *
     * @return Response
     */
    public function show($id)
    {

        return Response::json(
            array('success' => true,
                'payload' => User::find($id)->toArray(),
            ));
    }

    /**
     * Met à jour un bt
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        $input['password'] = Hash::make($input['password']);

        $validator = Validator::make($input, User::$rules);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $this->errorsArraytoString($validator->messages())
                ),
                400);

        $user = User::find($id);

        $user->fill($input);
        $user->save();

        return Response::json(
            array('success' => true,
                'payload' => $user->toArray(),
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
        $input['password'] = Hash::make($input['password']);

        $validator = Validator::make($input, User::$rules);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $validator->messages()
                ),
                400);

        $user = User::create($input);
        $user->points = Config::get('app.points');
        $user->save();

        return Response::json(
            array('success' => true,
                'payload' => $user->toArray(),
            ));
    }

}