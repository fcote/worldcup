<?php
/**
 * Controlleur permetant la gestion des paris
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


class BetController extends BaseController {


    /**
     * Renvoi tout les paris en JSON
     *
     * @return Response
     */
    public function index()
    {
        $user = User::getUserWithToken($_GET['token']);

        return Response::json(
            array('success' => true,
                'payload' => Bet::where('user_id', $user->id)->get()->toArray(),
            ));
    }

    /**
     * Renvoi un paris
     *
     * @return Response
     */
    public function show($id)
    {

        $user = User::getUserWithToken($_GET['token']);

        return Response::json(
            array('success' => true,
                'payload' => Bet::whereRaw('user_id = ? && id = ?', array($user->id), $id)->toArray(),
            ));
    }

    /**
     * Enregistre un nouveau paris
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $validator = Validator::make($input, Bet::$rules);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $validator->messages()
                ),
                400);

        $bet = Bet::create($input);

        return Response::json(
            array('success' => true,
                'payload' => $bet->toArray(),
            ));
    }

}