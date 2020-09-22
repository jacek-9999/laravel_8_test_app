<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Broker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AssignAgentToBrokerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAssignAgentToValidBroker()
    {
        $agentAssigning = Agent::first();
        $loginPayload = json_encode(['email' => $agentAssigning->email, 'password' => 'password']);
        $response = $this
            ->call(
                'POST',
                'login', [], [], [],
                ['CONTENT_TYPE' => 'application/json'],
                $loginPayload
            );
        $token = json_decode($response->content());

        $agentForAssign = Agent::factory()->create();
        $this->assertNull($agentForAssign->broker_id);
        $response = $this
            ->call(
                'PUT',
                "/agent/{$agentForAssign->id}/assign/{$agentAssigning->broker_id}", [], [], [],
                [
                    'CONTENT_TYPE' => 'application/json',
                    'authorization' => "Bearer {$token->access_token}"
                ]
            );
        $agentAfterAssign = Agent::where('id', $agentForAssign->id)->first();
        $this->assertEquals($agentAssigning->broker_id, $agentAfterAssign->broker_id);
        $this->assertTrue(true);
    }
}
