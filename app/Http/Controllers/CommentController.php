<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'football_pitch_id' => 'required|exists:football_pitches,id',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'football_pitch_id' => $request->football_pitch_id,
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Bình luận đã được thêm.');
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        if ($user->role == UserRole::Employee || $user->role == UserRole::CourtOwner || $user->id == $comment->user_id) {
            $comment->delete();
            return back()->with('success', 'Bình luận đã được xóa.');
        }

        return back()->with('error', 'Bạn không có quyền xóa bình luận này.');
    }
}
