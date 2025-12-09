<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function votePost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'vote' => 'required|in:1,-1',
        ]);

        $existingVote = Vote::where([
            'user_id' => auth()->id(),
            'voteable_id' => $post->id,
            'voteable_type' => Post::class,
        ])->first();

        if ($existingVote) {
            if ($existingVote->vote == $validated['vote']) {
                $existingVote->delete();
                $this->updateVoteCount($post);
                return back();
            }
            $existingVote->update(['vote' => $validated['vote']]);
        } else {
            Vote::create([
                'user_id' => auth()->id(),
                'voteable_id' => $post->id,
                'voteable_type' => Post::class,
                'vote' => $validated['vote'],
            ]);
        }

        $this->updateVoteCount($post);
        $this->updateUserKarma($post->user);

        return back();
    }

    public function voteComment(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'vote' => 'required|in:1,-1',
        ]);

        $existingVote = Vote::where([
            'user_id' => auth()->id(),
            'voteable_id' => $comment->id,
            'voteable_type' => Comment::class,
        ])->first();

        if ($existingVote) {
            if ($existingVote->vote == $validated['vote']) {
                $existingVote->delete();
                $this->updateVoteCount($comment);
                return back();
            }
            $existingVote->update(['vote' => $validated['vote']]);
        } else {
            Vote::create([
                'user_id' => auth()->id(),
                'voteable_id' => $comment->id,
                'voteable_type' => Comment::class,
                'vote' => $validated['vote'],
            ]);
        }

        $this->updateVoteCount($comment);
        $this->updateUserKarma($comment->user);

        return back();
    }

    private function updateVoteCount($model)
    {
        $model->votes = $model->votes()->sum('vote');
        $model->save();
    }

    private function updateUserKarma($user)
    {
        $postKarma = $user->posts()->sum('votes');
        $commentKarma = $user->comments()->sum('votes');
        $user->karma = $postKarma + $commentKarma;
        $user->save();
    }
}
