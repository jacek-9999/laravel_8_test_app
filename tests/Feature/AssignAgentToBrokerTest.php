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
        $response->assertStatus(200);
    }

    public function testAssignAgentToInvalidBroker()
    {
        $broker1 = Broker::first();
        $broker2 = Broker::skip(1)->first();
        $this->assertNotEquals($broker1->id, $broker2->id);
        $agentAssigning = Agent::where('broker_id', $broker1->id)->first();
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
                "/agent/{$agentForAssign->id}/assign/{$broker2->id}", [], [], [],
                [
                    'CONTENT_TYPE' => 'application/json',
                    'authorization' => "Bearer {$token->access_token}"
                ]
            );
        $agentAfterInvalidAssign = Agent::where('id', $agentForAssign->id)->first();
        $this->assertEquals($agentAfterInvalidAssign->broker_id, null);
        $this->assertEquals('{"status":"Unauthorized"}', $response->content());
        $response->assertStatus(401);
    }
}
