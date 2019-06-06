<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\MenuRepositoryEloquent;

class AsignaHerramientasController extends Controller
{
    //
    protected $menu; 

    public function __construct(MenuRepositoryEloquent $menu)
    {
        $this->middleware('auth');

        $this->menu = $menu;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$menu_info = $this->menu->find(1);

    	if($menu_info->count() > 0)
    	{
    		/* get the info and make the arrays */
    		$menu = json_decode($menu_info->content,true);

    		if(count($menu) > 0)
    		{
    			$data = $this->getLevelsFromArrays($menu);	
    		}else{
    			$data = array(
		    		"first_level" 	=> '[]',
		    		"second_level"	=> '[]',
		    		"third_level"	=> '[]',
		    	);	
    		}

    		

    	}else{
    		/* load the view with the info saved */
	    	$data = array(
	    		"first_level" 	=> '[]',
	    		"second_level"	=> '[]',
	    		"third_level"	=> '[]',
	    	);	
    	}   	
    	return view('asignaherramientas', $data);
    }

    /**
     * Returns an array with first, second and third values to display the menu.
     * @param 
	 *		menu. Array with menu saved in DB
	 *
	 * 
     * @return an array
     */
    protected function getLevelsFromArrays($menu)
    {
    	// get first level
    	foreach($menu as $j => $elements)
    	{	
    		foreach($elements as $i => $element)
    		{
	    		switch($i){
		   			case "info":
		   				$first_level []= $element;
		   				break ;
		   			case "childs":
		   				$second_level_complete[]= $element;
		   				break ;	
	    		}	
    		}		
    	}

    	foreach ($second_level_complete as $j => $elements) 
    	{
    		foreach($elements as $i => $element)
    		{
		   		$second_level []= $element["info"];
		   		
		   		if(count($element["childs"]))
		   		{
		   			$third_level_complete[]= $element["childs"];	
		   		}
    		}
    	}

    	foreach ($third_level_complete as $elements) 
    	{	
    		foreach($elements as $e)
    		{
    			$third_level []= $e;
    		}
    	}

    	$data = array(
    		"first_level" => json_encode($first_level),
    		"second_level" => json_encode($second_level),
    		"third_level" => json_encode($third_level),

    	);

    	return $data;
    }
}
