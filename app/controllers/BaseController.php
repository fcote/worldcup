<?php

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

    public function query_params($query)
    {

        // Build the query, filtering results by the provided query parameters
        if (Input::get())
        {

            $columns = $query->filters;

            if($columns != null){
                $i = 0;
                foreach (Input::get() as $key => $param)
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
