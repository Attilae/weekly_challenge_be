<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $challenges
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $challenge = Challenge::create($request->all());
        return [
            "status" => 1,
            "data" => $challenge
        ];
    }
}
