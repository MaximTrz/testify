<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHomePageStatus(): void
    {
        $response = $this->get('/');
        $this->assertContains($response->status(), [200, 302]);
    }
}
