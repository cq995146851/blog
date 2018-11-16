<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = \App\Models\User::all()->pluck('id')->toArray();
        $articles_ids = \App\Models\User::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);
        $comments = factory(\App\Models\Comment::class)
            ->times(200)
            ->make()
            ->each(function($comment) use ($user_ids, $articles_ids, $faker) {
                $comment->user_id = $faker->randomElement($user_ids);
                $comment->article_id = $faker->randomElement($articles_ids);
            });
        \App\Models\Comment::insert($comments->toArray());

    }
}
