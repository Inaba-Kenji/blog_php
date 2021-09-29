<?php

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Comment;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Blog::class, 10)
            ->create()
            ->each(
                function ($blog) {
                    $comments = factory(Comment::class, 2)->make();
                    $blog->comments()->saveMany($comments);
                }
            );
    }
}
