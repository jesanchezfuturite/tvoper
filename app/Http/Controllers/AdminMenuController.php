<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\MenuRepositoryEloquent;


class AdminMenuController extends Controller
{
    //

	 /**
     * Create a new controller instance.
     *
     * @return void
     */

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

    		$data = $this->getLevelsFromArrays($menu);

    	}else{
    		/* load the view with the info saved */
	    	$data = array(
	    		"first_level" 	=> '[]',
	    		"second_level"	=> '[]',
	    		"third_level"	=> '[]',
	    	);	
    	}   	
    	return view('adminmenu', $data);
    }

    /**
     * Save the menu in DB.
     * @param request. Fields in the forms in the view
	 *
	 * 
     * @return to the view admin
     */

    public function saveMenu(Request $request)
    {

    	// receive the arrays and check 

    	$first_level = json_decode($request->first_level,true);
    	$second_level = json_decode($request->second_level,true);
    	$third_level = json_decode($request->third_level,true);

    	// reads the third level and identify the fathers
    	$fathers_second_level = array();
    	
    	foreach($third_level as $t => $values)
    	{
    		if( !in_array($values['id_father'], $fathers_second_level) )
    		{
    			$fathers_second_level []= $values['id_father'];
    		}
    	}

    	// add the empty elements in second level
    	$addElementsEmptyPerLevel = $this->addElementsEmptyPerLevel($second_level,$fathers_second_level);
    	// get the childs 
    	$related_t = array();
    	foreach($fathers_second_level as $fs)
    	{
    		$related_t [$fs]= array(
    							"info"	=> $this->searchNode($fs,$second_level),
    							"childs" => $this->associateArray($third_level,$fs)
    						);

    	}
    	// add null elements in the array related
    	foreach($addElementsEmptyPerLevel as $n)
    	{
    		$related_t [$n]= array(
    							"info"	=> $this->searchNode($n,$second_level),
    							"childs" => array()
    						);
    	}

    	$related_second = array();
    	// add childs to the second level array
    	foreach($related_t as $second_id => $third_array)
    	{
    		$related_second []= array();
    	}

    	/* generate the principal level menu */

    	$fathers_first_level = array();
    	
    	foreach($first_level as $fl => $values)
    	{
    		$fathers_first_level []= $values["id"];
    	}

    	$related_s = array();
    	foreach($fathers_first_level as $ff)
    	{
    		$related_s [$ff]= array(
    							"info"	=> $this->searchNode($ff,$first_level),
    							"childs" => $this->associateArray($second_level,$ff)
    						);

    	}

    	/* generate the final menu array */
    	$menu_array = $this->generateFinalArray($related_s,$related_t);

    	/* save in DB info and reload the view */
    	try
    	{
    		$answer = $this->menu->updateOrCreate(
    					[ 'id'		=> 1 ],
    					[ 'content'	=>	 json_encode($menu_array)]	
    				);	

    	}catch( \Exception $e){
    		Log::info('Error while save menu in DB: '.$e->getMessage());
    		
    	}

    	return redirect('/adminmenu');
    }


    /**
     * Returns the associative elements with the key provided.
     * @param request. Fields in the forms in the view
	 *
	 * 
     * @return an array
     */

    protected function associateArray($array,$key)
    {
    	$temp = array();
    	
    	foreach($array as $tl => $values)
		{
			if($key == $values["id_father"]){
				$temp []= $values;
			}
		}

		return $temp;
    }


    /**
     * Returns the associative elements with the key provided.
     * @param 
	 *		original. is the array which has the info from the desired level 
	 *		created. is the related array created from original with the sub menu 
	 *
	 * 
     * @return an array with the ids from original what should be added
     */

    protected function addElementsEmptyPerLevel($original,$created)
    {
    	$temp = array();
    	$extra = array();
    	foreach($original as $o)
    	{
    		$temp []= $o["id"];
    	}

    	foreach($temp as $t)
    	{
    		if( !in_array($t, $created) )
    		{
    			$extra []= $t;
    		}
    	}

		return $extra;
    }



    /**
     * Returns the node in array with id specified.
     * @param 
	 *		id. Id field in array searched 
	 *		array. Source from data required 
	 *
	 * 
     * @return a node from original array, false if error
     */

    protected function searchNode($id,$array)
    {
    	foreach($array as $i => $info)
    	{
    		if($info["id"] == $id)
    		{
    			return $info;
    		}
    	}

    	return false;
    }

	/**
     * Returns an array to be transformed to json string to save in DB.
     * @param 
	 *		second. Array related to first and second levels 
	 *		third . Array related to second and third levels 
	 *
	 * 
     * @return a node from original array, false if error
     */

    protected function generateFinalArray($second,$third)
    {
    	foreach($second as $s => $info)
    	{
    		// we have to explode child and merge with the third array
    		$child_complete = array();
    		$child = $info["childs"];

    		if(count($child))
    		{
    			foreach($child as $c)
    			{
    				$child_complete []= $third[$c["id"]];
    			}
    		}

    		$final []= array
    			(
    				"info"		=> $info["info"],
    				"childs"	=> $child_complete
    			);

    		unset($child,$child_complete);
    	}

    	return $final;
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
