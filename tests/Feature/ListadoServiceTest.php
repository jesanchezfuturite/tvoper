<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ListadoServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $limit = 10;
        $response = $this->getJson("/get-all-tramites/113?limit={$limit}&group_by=clave&status=99&page=1&start_date=2021-08-02&end_date=2021-09-01");
        $data = $response->baseResponse->original;
        dd($data);
        $response->assertJsonStructure([
            'pages' => [
                'current',
                'total'
            ],
            'tickets',
            'totals' => [
                'global',
                'filtered'
            ]
        ])
        ->assertJsonCount($limit, 'tickets')
        ->assertStatus(200);
        $this->assertEquals($limit, $data["totals"]["filtered"]);
    }
}
