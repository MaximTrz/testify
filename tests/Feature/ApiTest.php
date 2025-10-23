<?php

namespace Tests\Feature;

use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(3);
        Sanctum::actingAs($this->user);
    }

    public function testGet()
    {
        $test = Test::factory()->create();
        $response = $this->getJson("/api/tests/{$test->id}");
        $response->assertJsonStructure([
            'message',
        ]);
    }

}
