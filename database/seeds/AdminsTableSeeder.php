<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory(App\Admin::class, 100)->create()->each(function ($u) {
            $u->posts()->save(factory(App\Post::class)->make());
        });

        Model::reguard();
    }
}
