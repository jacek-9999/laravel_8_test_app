<?php

namespace Tests\Feature;

use App\Models\Broker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAgentsByBrokerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAgentsByBroker()
    {
        $brokerId = Broker::first()->id;
        $response = $this->get("/agents/$brokerId");
        var_dump($response->getContent());
        $response->assertStatus(200);
    }
}
