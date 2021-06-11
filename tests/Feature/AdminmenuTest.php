<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminmenuTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testGetIndex()
    {
        $response = $this->get('/adminmenu');
        $this->assertEquals(302,$response->getStatusCode());        
    }

    public function testRedirecttoLogin()
    {
        $this->get('/adminmenu')->assertRedirect('login');
    }


    /*

        Al probar login, siempre redirecciona a /register el cual condicionalmente debe mostrar 
        un form de registro pero no existe.
    */
    // public function testLoginRedirect()
    // {
    //     $response = $this->call('POST', '/login', [
    //         'email' => 'cerdaduran@gmail.com',
    //         'password' => 'badPass',
    //         '_token' => csrf_token()
    //     ]);
        
    //     dd($response);

    //     $this->assertEquals(200, $response->getStatusCode());
    //     $this->assertEquals('auth.login', $response->original->name());
        
    // }

    public function testSaveMenuEmptyRequest()
    {
        $this->withoutMiddleware();

        $response = $this->post('/adminmenu/saveMenu',[]);
        $this->assertEquals(200,$response->getStatusCode());

    }
}
