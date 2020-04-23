<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    public function test2Example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function test3Example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function test4Example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function test5Example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
        $response->assertStatus(200);
    }
    public function test6Example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
       
       
        $response->assertStatus(200);
        $response->assertStatus(200);
    }
    public function test7Example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
