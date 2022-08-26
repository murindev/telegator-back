<?php

namespace Database\Seeders;

use App\Models\Post\Post;
use App\Models\Post\PostMedia;
use App\Models\Post\PostView;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

//        $channels

        for ($item = 1; $item <= 10; $item++) {
            $postsCnt = rand(5, 20);
            for ($posts = 1; $posts <= $postsCnt; $posts++) {


                $postId = Post::insertGetId([
                    'channel_id' => $item,
                    'title' => $faker->sentence(6),
                    'content' => $faker->paragraph(3),
                    'views_cnt' => $faker->numberBetween(1, 10000),
                    'forwards_cnt' => $faker->numberBetween(1, 10000),
                    'is_advert' => $faker->numberBetween(0, 1),
                    'engagement_rate' => $faker->numberBetween(1, 100),
                    'comments_cnt' => $faker->numberBetween(1, 1000),
                    'reactions_cnt' => $faker->numberBetween(1, 100),
                    'duration' => $faker->numberBetween(1, 100),
                    'purity_duration' => $faker->numberBetween(1, 100),
                    'created_at' => $faker->dateTimeThisMonth(),
                    'updated_at' => $faker->dateTimeThisMonth(),
                    'is_faker' => true,
                ]);

                PostMedia::insert([
                    'channel_id' => $item,
                    'post_id' => $postId,
                    'media' => 'https://placeimg.com/640/400/any',
                ]);


                for ($i = 1; $i <= 24; $i++) {
                    PostView::insert([
                        'channel_id' => $item,
                        'post_id' => $postId,
                        'post_nr' => 300 + $item,
                        'hour' => $i,
                        'percentage' => $faker->randomFloat(2, 0, 98),
                        'views_cnt' => $faker->numberBetween(1, 10000),
                        'tg_stat_created_at' => $faker->dateTimeThisMonth(),
                    ]);
                }

            }


        }


    }
}
