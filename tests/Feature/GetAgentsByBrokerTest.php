<?php

namespace Tests\Feature;

use App\Models\Agent;
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
        $agent = Agent::first();
        $loginPayload = json_encode(['email' => $agent->email, 'password' => 'password']);
        $response = $this
            ->call(
                'POST',
                'login', [], [], [],
                ['CONTENT_TYPE' => 'application/json'],
                $loginPayload
            );
        $token = json_decode($response->content());
        $brokerId = Broker::first()->id;
        $response = $this->get(
            "/agents/$brokerId",
            ['authorization' => "Bearer {$token->access_token}"]);
        foreach (json_decode($response->getContent()) as $agent) {
            if ($agent->broker_id !== $brokerId) {
                $this->fail('broker id is invalid');
            }
        }
        $response->assertStatus(200);
    }
}
