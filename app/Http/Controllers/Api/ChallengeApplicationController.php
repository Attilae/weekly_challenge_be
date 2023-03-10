<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChallengeApplication;
use Illuminate\Http\Request;

class ChallengeApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = ChallengeApplication::where('challenge_id', $request->id)->with('user')->get();
        return [
            "status" => 1,
            "data" => $applications
        ];
    }

    public function show(Request $request)
    {
        $application = ChallengeApplication::with('user')->find($request->id);

        return [
            "status" => 1,
            "data" => [
                'url' => $application->url,
                'user' => $application->user
            ]
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);

        $application = new ChallengeApplication();
        $application->url = $request->url;
        $application->user_id = $request->user_id;
        $application->challenge_id = $request->challenge_id;
        $application->save();

        return [
            "status" => 1,
            "data" => $application
        ];
    }
}
