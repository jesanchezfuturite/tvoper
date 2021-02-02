<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\Auth;
use App\Repositories\AdministratorsRepositoryEloquent;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $menudb;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdministratorsRepositoryEloquent $menudb)
    {
        $this->middleware('auth');

        $this->menudb=$menudb;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $this->registerMenu($data['email']);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => 1,
            'password' => Hash::make($data['password']),
        ]);

    }


    protected function validateUser($user)
    {
        try
        {
            return view("home");    
        }catch( \Exception $e){
            dd($e-getMessage());
        }
        
    }

    private function registerMenu($name)
    {
        $this->menudb->create(["name"=>$name,"is_admin"=>0,"extra"=>"[]","menu"=>"[]"]);
    }

}
