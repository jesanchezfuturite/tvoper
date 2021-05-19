<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\MenuRepositoryEloquent;

use App\Repositories\UsersRepositoryEloquent;

use App\Repositories\AdministratorsRepositoryEloquent;

use App\Repositories\OperacionUsuariosEstatusRepositoryEloquent;

use App\Repositories\PortalSolicitudesStatusRepositoryEloquent;

class AsignaHerramientasController extends Controller
{
    //
    protected $menu;
    protected $users; 

    public function __construct(
        MenuRepositoryEloquent $menu,
        UsersRepositoryEloquent $users,
        AdministratorsRepositoryEloquent $admins,
        OperacionUsuariosEstatusRepositoryEloquent $userEstatus,
        PortalSolicitudesStatusRepositoryEloquent $status
    )
    {
        $this->middleware('auth');

        $this->menu = $menu;

        $this->users = $users;

        $this->admins = $admins;

        $this->userEstatus = $userEstatus;

        $this->status = $status;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* get the user list */
        $user_id = auth()->user()->id;

        $status = $this->status->all()->toArray();

        $name = $this->admins->where("creado_por", $user_id)->pluck('name')->toArray();             

        $users = $this->users->whereIn("email", $name)->where( [ 'status' => 1 ] )->get();
     
        
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

        $data ["users"]= $users;
        $data["status"]=$status;

    	return view('asignaherramientas', $data);
    }

    /**
     * Loads the view from index.
     * @param 
     *      request. Variable saved_tools in json has the json tools added at user and profile 
     *
     * 
     * @return an array
     */
    public function saveUserProfile(Request $request)
    {
        /* here i have to modify to just save the identifier */
        try{
            $this->admins->updateMenuByName( ['name' => $request->username], [ 'menu' => $request->tools ]);
        }catch( \Exception $e){
            Log::info('[AsignaHerramientasController@saveUserProfile] Error ' . $e->getMessage());    
        }
        
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
    	$first_level = $second_level = $second_level_complete = $third_level = $third_level_complete = array();

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


    /**
     * Looks for the menu assigned to the user .
     * @param 
     *      menu. Array with menu saved in DB
     *
     * 
     * @return an array
     */
    public function loadUserProfile(Request $request)
    {
        #get the menu saved
        $users = $this->admins->findWhere( [ "name" => trim($request->username) ] );

        if($users->count())
        {
            foreach($users as $u)
            {
                $menu = $u->menu;
            }
            return $menu;
        }else{
            return "[]";
        }

    }

    /**
     * update the menu field in Admin Table.
     * @param 
     *      id => json identifier in menu field
     *
     * 
     * @return true if goes well
     */
    public function deleteElementUserProfile(Request $request)
    {
        
        $users = $this->admins->findWhere( [ "name" => trim($request->username) ] );

        try{
            $toDelete = $request->id;    
        }catch( \Exception $e){
            log::info("Error while update tools" . $e->getMessage() );
        }
        
        if($users->count())
        {
            foreach($users as $u)
            {
                $menu = $u->menu;
            }
            
            $menu  = json_decode($menu);

            foreach($menu as $m => $v)
            { log::info($toDelete);

                if($v->id == $toDelete)
                {
                    unset($menu[$m]);

                }
            }
            foreach($menu as $sub => $n)
            { 

                if($n->id_father == $toDelete)
                {
                    unset($menu[$sub]);

                }
            }

            //log::info($menu);
            /* here change to json and updates the db*/

            try{
                //log::info($menu);
                $this->admins->updateMenuByName( ['name' => $u->name ], [ 'menu' => json_encode($menu) ]);

                return 1 ;

            }catch( \Exception $e){
                log::info('[AsignaHerramientasController@deleteElementUserProfile] Error ' . $e->getMessage());   

                return 0;

            }
        }
    }

    public function saveUserStatus(Request $request){
        try{
            $userEstatus = $this->userEstatus->updateOrCreate(["id_usuario" =>$request->id_usuario],
              [
                "estatus"=> json_encode($request->estatus)
              ]);
              return response()->json(
                [
                  "Code" => "200",
                  "Message" => "Estatus actualizado"
                ]);
        }catch( \Exception $e){
            return response()->json(
                [
                  "Code" => "400",
                  "Message" => "Error"
                ]);
            Log::info('[AsignaHerramientasController@saveUserEstatus] Error ' . $e->getMessage());    
        }
    }

}
