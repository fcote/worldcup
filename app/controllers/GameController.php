<?php
/**
 * Controlleur permetant la gestion des matches
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


class GameController extends BaseController {


    /**
     * Renvoi tout les matches en JSON
     *
     * @return Response
     */
    public function index()
    {
        return Response::json(
            array('success' => true,
                'payload' => $this->query_params(new Game())->toArray(),
            ));
    }

    /**
     * Renvoi un matche
     *
     * @return Response
     */
    public function show($id)
    {
        return Response::json(
            array('success' => true,
                'payload' => Game::find($id)->toArray(),
            ));
    }

}