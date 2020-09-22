<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Broker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ScopeWithoutEstatesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testScopeWithoutEstates()
    {
        $thisAgentIsLazyAndDontHaveAnyEstate = Agent::factory()->create();
        $thisLazyAgentLikesBrowsingRedditInOffice = Agent::factory()->create();
        $tableOfShame = [
           $thisAgentIsLazyAndDontHaveAnyEstate->id,
           $thisLazyAgentLikesBrowsingRedditInOffice->id
        ];
        foreach (Agent::withoutEstates()->get() as $agent) {
            $this->assertTrue(in_array($agent->id, $tableOfShame));
        }
    }
}
