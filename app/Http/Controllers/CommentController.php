<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['user', 'item'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get all comments',
            'data' => $comments
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $comment = Comment::create($validated);
        $comment = Comment::with(['user', 'item'])->find($comment->id);

        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully',
            'data' => $comment
        ], 201);
    }

    public function show($id)
    {
        $comment = Comment::with(['user', 'item'])->find($id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get comment detail',
            'data' => $comment
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found'
            ], 404);
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'data' => $comment
        ], 200);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found'
            ], 404);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ], 200);
    }
    public function byItem($id)
{
    $comments = Comment::with(['user', 'item'])
                ->where('item_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

    return response()->json([
        'success' => true,
        'message' => 'Get comments by item ID',
        'data' => $comments
    ], 200);
}




}
