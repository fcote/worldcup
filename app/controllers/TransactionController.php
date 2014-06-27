<?php
/**
 * Controlleur permetant la gestion des matches
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


class TransactionController extends BaseController {


    /**
     * Renvoi toutes les transaction en JSON
     *
     * @return Response
     */
    public function index()
    {
        $user = User::getUserWithToken($_GET['token']);
        $transaction = new Transaction();
        $transaction->where('user_id', $user->id, "AND");

        return Response::json(
            array('success' => true,
                'payload' => $this->query_params($transaction)->toArray(),
            ));
    }

    /**
     * Renvoi une transaction
     *
     * @return Response
     */
    public function show($id)
    {

        $user = User::getUserWithToken($_GET['token']);

        return Response::json(
            array('success' => true,
                'payload' => Transaction::whereRaw('user_id = ? && id = ?', array($user->id), $id)->toArray(),
            ));
    }

    /**
     * Ajoute une transaction
     * Utilisé uniquement par le code
     *
     * @param $user_id
     * @param $bet_id
     * @param $value
     * @param $type
     * @return bool
     */
    public static function addTransaction($user_id, $bet_id, $value, $type){
        if(in_array($type, array('gain', 'bet')) && Bet::find($bet_id)){
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->bet_id = $bet_id;
            $transaction->value = $value;
            $transaction->type = $type;

            $transaction->save();

            //On déduit/ajoute les point de la transaction
            $user = User::find($user_id);

            if($transaction->type == "bet")
                $user->points -= $transaction->value;
            else if ($transaction->type == "gain")
                $user->points += $transaction->value;

            $user->save();
        }

        return false;
    }

}