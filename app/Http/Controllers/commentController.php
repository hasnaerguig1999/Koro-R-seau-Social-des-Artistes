<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class commentController extends Controller
{
    public function index(){
        $comments = Comment::all();
        return response()->json($comments);
    }

    public function store(Request $request){
        $request->validate([
            'content' => 'required|string',
        'weight' => 'required|numeric',
        'creation_date' => 'required|date',
        'sub_comments' => 'required|array',
        'supports' => 'required|array',
        ]);

        $comment = Comment::create([
            'content' => $request->content,
            'weight' => $request->weight,
            'creation_date' => $request->creation_date,
            'sub_comments' => $request->sub_comments,
            'supports' => $request->supports,

        ]);

        return response()->json($comment, 201);
    }

    public function destroy($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(null, 204);
    }

    public function show($id){
        $comment = Comment::findOrFail($id);
        return response()->json($comment);
    }

    public function update(Request $request, $id){
        $request->validate([
            'content' => 'required|string',
        'weight' => 'required|numeric',
        'creation_date' => 'required|date',
        'sub_comments' => 'required|array',
        'supports' => 'required|array',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update([
            'content' => $request->content,
        ]);

        return response()->json($comment);
    }
}
