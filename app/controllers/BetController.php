<?php
/**
 * Controlleur permetant la gestion des paris
 *
 * PHP version 5.5
 *
 * @category   Controller
 * @package    worldcup\app\controllers
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
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

        $bet = new Bet();
        $_GET['user_id'] = $user->id;

        return Response::json(
            array('success' => true,
                'payload' => $this->query_params($bet)->toArray(),
            ));
    }

    /**
     * Renvoi toutes les écarts possibles
     *
     * @return Response
     */
    public function distances()
    {
        return Response::json(
            array('success' => true,
                'payload' => Bet::getDistances(),
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
        $user = User::getUserWithToken($_GET['token']);

        $input = Input::all();
        $input['user_id'] = $user->id;

        $validator = Validator::make($input, Bet::$rules, BaseController::$messages);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $this->errorsArraytoString($validator->messages())
                ),
                400);

        //On vérifie si la date du match n'est pas dépassé
        if(new DateTime() > new DateTime(Game::find($input['game_id'])->date))
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Le date du match est dépassé !"
                ),
                400);

        $bet = Bet::whereRaw('user_id = ? && game_id = ?', array($input['user_id'], $input['game_id']))->first();
        //Si un paris sur le même match pour cet utilisateur existe, erreur envoyée.
        if($bet)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Un paris existe déjà sur ce match !"
                ),
                400);

        //On vérifie si la somme misé est disponible
        if($input['points'] > $user->points)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Vous avez miser plus de points que vous en avez !"
                ),
                400);

        $game = Game::find($input['game_id']);

        //On vérifie si le winner est bien une équipe du match
        if($input['winner_id'] != $game->team1_id && $input['winner_id'] != $game->team2_id)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Veuillez mettre une équipe du match !"
                ),
                400);

        $bet = Bet::create($input);

        Transaction::addTransaction($input['user_id'], $bet->id, $input['points'], 'bet');

        return Response::json(
            array('success' => true,
                'payload' => $bet->toArray(),
                'message' => 'Pari enregistré ('.$bet->points.' points) sur : '.$game->team1->name.' - '.$game->team2->name
            ));
    }

}