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
        $response = $this->get(route('admin.home'));

        $response->assertStatus(302);
    }
    public function test_users_route()
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(302);
    }
    public function test_food_route()
    {
        $response = $this->get(route('admin.food.index'));

        $response->assertStatus(302);
    }

}
