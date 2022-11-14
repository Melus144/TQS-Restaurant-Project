<?php

use Tests\TestCase;

class RoutesBackofficeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_admin_route()
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
    }
    public function test_users_route()
    {
        $response = $this->get('/users/list');

        $response->assertStatus(302);
    }
    public function test_food_route()
    {
        $response = $this->get('/food/list');

        $response->assertStatus(302);
    }
    public function test_recipes_route()
    {
        $response = $this->get('/recipes/list');

        $response->assertStatus(302);
    }
    public function test_stock_route()
    {
        $response = $this->get('/stock/list');

        $response->assertStatus(302);
    }
}
