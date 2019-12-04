<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\AdministratorsRepositoryEloquent;

use App\Repositories\MenuRepositoryEloquent;

class HomeController extends Controller
{


    protected $admin ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( 
        AdministratorsRepositoryEloquent $admin,
        MenuRepositoryEloquent $menu
     )
    {
        $this->middleware('auth');

        // define the repositories

        $this->admin = $admin;
        $this->menu = $menu;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {    
        $user = Auth::user()->email;

        $this->defineUserPrivilegies($user);

        return view('home');
    }


    /**
    * at this moment is the first time, when user is logged in...
    * I have to save a session variable with profile details
    * which will be used in permission middleware to check  
    *
    *
    * @return null  
    *
    */

    public function defineUserPrivilegies($user)
    {
        // check if the user is admin
        $results = $this->admin->findByField('name',$user);

        $results = $results [0];

        if($results->is_admin == 1)
        {
            $var = true;
        }else{
            $var = false;
        }

        session( ["is_admin" => $var, "menu" => $this->configureMenu($results->menu) ] );

    }

    /**
    * Configure Menu: This method returns an array with the permissions to the logged user
    * 
    * @param 
    *   $ menu_user . It's a json string with the elements assigned to the profile
    *
    *
    * @return null  
    *
    */
    protected function configureMenu($menu_user)
    {

        $menu_user = empty($menu_user) ? [] : json_decode($menu_user);

        if(count($menu_user) > 0)
        {
            # get fathers
            $fathers_nodes = $this->getFatherNodes();

            foreach($menu_user as $mu => $data)
            {
                if(array_key_exists($data->id_father, $fathers_nodes)){
                    $father [$data->id_father]= $fathers_nodes[$data->id_father];
                }             
            }

            $array_menu = array('father' => $father, 'childs' => $menu_user);

        }else{
            // el usuario no tiene herramientas asignadas
            $array_menu = false;
        }

        return $array_menu;

    }

    protected function getFatherNodes()
    {
        $menu = $this->menu->find(1);

        $menu = json_decode($menu->content);

        foreach($menu as $m => $values)
        {
            $response [(string)$values->info->id]= $values->info->title;
        }
        //log::info($response);
        return $response;
    }
    
}
