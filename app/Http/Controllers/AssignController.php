<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignController extends Controller
{
    public function assignAgentToBroker(Request $request, $agentId, $brokerId) {
        if (Auth::user()->broker_id !== intval($brokerId)) {
            return response()->json(['status' => 'Unauthorized'], 401);
        }
        $editedAgent = Agent::where('id', $agentId)->first();
        $editedAgent->broker_id = $brokerId;
        $editedAgent->save();
        return response()->json(['status' => 'Success']);
    }
}
