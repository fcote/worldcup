<?php
/**
 * Controlleur principal
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

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    protected function errorsArraytoString($messages){
        $mess = "";
        foreach ($messages->all() as $message)
        {
            $mess .= $message." <br/>";
        }
        return $mess;
    }

    public static $messages = array(
        'required' => 'Le champ :attribute est obligatoire !',
        'numeric' => 'Le champ :attribute doit être numérique !',
        'integer' => 'Le champ :attribute doit être un entier',
        'email' => 'Le champ :attribute doit être une adresse valide !'
    );

    public function query_params($query)
    {

        // Build the query, filtering results by the provided query parameters
        if (Input::get())
        {

            $columns = $query->filters;

            if($columns != null){

                $i = 0;
                foreach ($_GET as $key => $param)
                {

                    if(substr($key, strlen($key)-1, 1) == "!"){
                        $key = substr($key, 0, strlen($key)-1);

                        $operator = "!=";
                    }else{
                        $operator = "=";
                    }

                    if(in_array($key, $columns)){

                        if($param == 'null'){
                            if($i == 0){
                                if($operator == "=")
                                    $query = $query->whereNull($key);
                                else
                                    $query = $query->where($key, "<>", 'NULL');
                            }else{
                                if($operator == "=")
                                    $query = $query->whereNull($key, 'AND');
                                else
                                    $query = $query->where($key, "<>", 'NULL', 'AND');
                            }
                        }else{
                            if($i == 0)
                                $query = $query->where($key, $operator, $param);
                            else
                                $query = $query->where($key, $operator, $param, 'AND');
                        }

                        $i++;
                    }
                }
            }

            if (Input::get('limit')) $query = $query->take(Input::get('limit'))->skip(Input::get('offset'));
            if (Input::get('orderby'))	$query = $query->orderBy(Input::get('orderby'), Input::get('order'));
            //if ($query->count() == 1 || Input::get('limit') == 1) return $query->first();

            return $query->get();
        }
        else
        {
            return $query->get();
        }
    }

}
