<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesBackofficeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_admin()
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
    }
}
