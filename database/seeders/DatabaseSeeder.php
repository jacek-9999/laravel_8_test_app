<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Broker;
use App\Models\Agent;
use App\Models\Estate;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $brokers = Broker::factory(4)->create();
        foreach ($brokers as $broker) {
            Agent::factory(rand(2, 4))->create(['broker_id' => $broker->id]);
        }
        foreach (Agent::all() as $agent) {
            Estate::factory(rand(6, 12))->create(['agent_id' => $agent->id]);
            Client::factory(rand(3, 9))->create(['agent_id' => $agent->id]);
        }
    }
}
