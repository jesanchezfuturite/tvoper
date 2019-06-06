<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Repositories\AdministratorsRepositoryEloquent;

class HomeController extends Controller
{


    protected $admin ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( AdministratorsRepositoryEloquent $admin )
    {
        $this->middleware('auth');

        // define the repositories

        $this->admin = $admin;
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

    protected function defineUserPrivilegies($user)
    {
        // check if the user is admin
        $results = $this->admin->findByField('name',$user);

        $results = $results [0];

        if($results->is_admin == 1)
        {
            session( ["is_admin" => true] );
        }else{
            session( ["is_admin" => false] );
        }
    }

    
}
