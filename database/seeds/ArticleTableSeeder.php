<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('articles')->truncate();
        \Illuminate\Support\Facades\DB::table('users')->truncate();
        factory(App\Entities\User::class, 50)
            ->create()
            ->each(function($u) {
                $u->articles()->saveMany(factory(App\Entities\Article::class, 3)
                    ->make());
            });
    }
}
