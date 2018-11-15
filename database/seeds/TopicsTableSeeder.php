<?php

use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['旅游', '体育', '娱乐', '汽车', '科技', '手机', '数码'];
        $faker = app(Faker\Generator::class);
        $topics = factory(\App\Models\Topic::class)
            ->times(7)
            ->make()
            ->each(function ($topic, $index) use ($faker, $arr) {
                $topic->name = $arr[$index];
            });
        \App\Models\Topic::insert($topics->toArray());
    }
}
