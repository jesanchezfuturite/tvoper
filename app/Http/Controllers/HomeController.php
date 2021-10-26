<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\AdministratorsRepositoryEloquent;

use App\Repositories\MenuRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\EntidadRepositoryEloquent;
use App\Repositories\EntidadtramiteRepositoryEloquent;
use App\Repositories\TramitesRepositoryEloquent;
use Carbon\Carbon;

class HomeController extends Controller
{


    protected $admin ;
    protected $transaccionesdb;
    protected $entidaddb;
    protected $tramitesdb;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( 
        AdministratorsRepositoryEloquent $admin,
        MenuRepositoryEloquent $menu,
        TransaccionesRepositoryEloquent $transaccionesdb,
        EntidadRepositoryEloquent $entidaddb,
        TramitesRepositoryEloquent $tramitesdb

     )
    {
        $this->middleware('auth');

        // define the repositories

        $this->admin = $admin;
        $this->menu = $menu;
        $this->transaccionesdb=$transaccionesdb;
        $this->entidaddb=$entidaddb;
        $this->tramitesdb=$tramitesdb;
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

        /*if($results->is_admin == 1)
        {
            $var = true;
        }else{
            $var = false;
        }*/
	
        session( ["is_admin" => $results->is_admin, "menu" => $this->configureMenu($results->menu) ] );

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

    public function SearchEntidad(Request $request)
    {
        $data=array();
        $fecha=$this->DateNowRango(null,null);
        $find =$this->transaccionesdb->findREntidad($fecha["f_inicio"],$fecha["f_fin"]);
        $array1=array();
        $array2=array();
        foreach ($find as $k) {
            $array1 []= $k->entidad;
            $array2 []= $k->transacciones;
        }
        $mes=$this->obtenerMes(null,null);
        $data=array(
            "mes"=>$mes,
            "data_label"=>$array1,
            "data"=>$array2
        );
        return json_encode($data);
    }
    public function SearchRange(Request $request)
    {      
        $data=array();
        $mes=$this->obtenerMes($request->incio,$request->fin);
        $fecha=$this->DateNowRango($request->incio,$request->fin);
       
        $find =$this->transaccionesdb->findRTramites($fecha["f_inicio"],$fecha["f_fin"]); 
        $array1=array();
        $array2=array();
        foreach ($find as $k) {
            $array1 []= $k->tramite;
            $array2 []= $k->transacciones;
        }
        
        $data=array(
            "mes"=>$mes,
            "data_label"=>$array1,
            "data"=>$array2
        );
        return json_encode($data);
    }
    private function DateNowRango($f_inicio,$f_fin)
    {
        if($f_inicio==null || $f_inicio=="")
        {
            $f_inicio = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $f_fin = Carbon::now()->endOfMonth()->subMonth()->toDateString();
        }else{             
            $f_inicio=Carbon::parse($f_inicio)->format('Y-m-d');
            $f_fin=Carbon::parse($f_fin)->format('Y-m-d'); 
        }
       
        $date =array(
            "f_inicio"=>$f_inicio,
            "f_fin"=>$f_fin,
        );
        return $date;
    }
    private function obtenerMes($f,$fin)
    {      
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        $mes="";
        if($f==null || $f==""){
            $f = Carbon::now();
            $fin = Carbon::now();
        }else{
            $f=Carbon::parse($f);
            $fin=Carbon::parse($fin); 
        }           
        $f->diffForHumans();
        $fin->diffForHumans();
        $mes1 = $f->formatLocalized('%B');
        $mes2 = $fin->formatLocalized('%B');
        if($mes1!=$mes2)
        {
            $mes = $f->formatLocalized('%B') . " - " . $fin->formatLocalized('%B');
        }else{
            $mes=$f->formatLocalized('%B');
        }

        return $mes;
    }
    
}
