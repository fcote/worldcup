<?php
/**
 * Controlleur permetant la gestion de l'arbre
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


class BracketController extends BaseController {


    /**
     * Renvoi tout les matches en JSON
     *
     * @return Response
     */
    public function index()
    {
        $bracket = new Bracket();

        return Response::json(
            array('success' => true,
                'payload' => $bracket->getArray(),
            ));
    }

}