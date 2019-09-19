<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    /** @test*/
    public function a_user_can_browse_thread()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }
}
