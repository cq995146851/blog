<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = \App\Models\User::all()->pluck('id')->toArray();
        $topic_ids = \App\Models\Topic::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);
        $articles = factory(\App\Models\Article::class)
            ->times(200)
            ->make()
            ->each(function ($article, $index) use ($faker, $user_ids, $topic_ids) {
                $article->user_id = $faker->randomElement($user_ids);
                $article->topic_id = $faker->randomElement($topic_ids);
            });
        \App\Models\Article::insert($articles->toArray());
    }
}
