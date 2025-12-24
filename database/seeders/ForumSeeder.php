<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();

        $communities = [];
        $communityNames = ['Programming', 'Gaming', 'Music', 'Movies', 'Technology'];

        foreach ($communityNames as $name) {
            $communities[] = Community::create([
                'name' => $name,
                'description' => "A community for {$name} enthusiasts",
                'created_by' => $users->random()->id,
            ]);
        }

        foreach ($users as $user) {
            $user->subscribedCommunities()->attach(
                collect($communities)->random(rand(1, 3))->pluck('id')
            );
        }

        foreach ($communities as $community) {
            $posts = [];
            for ($i = 0; $i < rand(5, 15); $i++) {
                $posts[] = Post::create([
                    'community_id' => $community->id,
                    'user_id' => $users->random()->id,
                    'title' => fake()->sentence(),
                    'content' => rand(0, 1) ? fake()->paragraphs(rand(1, 3), true) : null,
                    'type' => 'text',
                ]);
            }

            foreach ($posts as $post) {
                for ($i = 0; $i < rand(0, 5); $i++) {
                    $comment = Comment::create([
                        'post_id' => $post->id,
                        'user_id' => $users->random()->id,
                        'content' => fake()->paragraph(),
                    ]);

                    if (rand(0, 1)) {
                        Comment::create([
                            'post_id' => $post->id,
                            'user_id' => $users->random()->id,
                            'parent_id' => $comment->id,
                            'content' => fake()->paragraph(),
                        ]);
                    }
                }

                foreach ($users->random(rand(1, 8)) as $voter) {
                    Vote::create([
                        'user_id' => $voter->id,
                        'voteable_id' => $post->id,
                        'voteable_type' => Post::class,
                        'vote' => rand(0, 1) ? 1 : -1,
                    ]);
                }
            }
        }

        foreach (Post::all() as $post) {
            $post->votes = $post->votes()->sum('vote');
            $post->save();
        }

        foreach (Comment::all() as $comment) {
            $comment->votes = $comment->votes()->sum('vote');
            $comment->save();
        }

        foreach (User::all() as $user) {
            $postKarma = $user->posts()->sum('votes');
            $commentKarma = $user->comments()->sum('votes');
            $user->karma = $postKarma + $commentKarma;
            $user->save();
        }
    }
}
