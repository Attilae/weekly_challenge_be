<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChallengeApplication;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        $comments = Comment::where('application_id', $request->id)->with('user')->get();
        return [
            "status" => 1,
            "data" => $comments
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $comment = new Comment();
        $comment->description = $request->description;
        $comment->user_id = $request->user_id;
        $comment->application_id = $request->application_id;
        $comment->save();

        return [
            "status" => 1,
            "data" => $comment
        ];

    }
}
