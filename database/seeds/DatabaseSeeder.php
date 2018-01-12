<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(OusTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(TermsTableSeeder::class);
        $this->call(MacsTableSeeder::class);

        Model::reguard();
    }
}


class OusTableSeeder extends Seeder
{
    public function run()
    {
        App\Ou::create([
            'name' => '根部门',
            'ou_id' => 1,
            'path' => '/根部门',
            'desp' => '',
        ]);
        App\Ou::create([
            'name' => '技术部',
            'ou_id' => 1,
            'path' => '/根部门/技术部',
            'desp' => '',
        ]);
        App\Ou::create([
            'name' => '销售部',
            'ou_id' => 1,
            'path' => '/根部门/销售部',
            'desp' => '',
        ]);
        App\Ou::create([
            'name' => '研发',
            'ou_id' => 2,
            'path' => '/根部门/技术部/研发',
            'desp' => '',
        ]);
        App\Ou::create([
            'name' => 'UED',
            'ou_id' => 2,
            'path' => '/根部门/技术部/UED',
            'desp' => '',
        ]);
    }
}



class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\User::class, 100)->create();

        // ->each(function ($u) {
        //     $u->posts()->save(factory(App\Post::class)->make());
        // });
    }
}

class AdminsTableSeeder extends Seeder
{
    public function run()
    {

        App\Admin::create([
            'name' => 'admin',
            'email' => 'alvinhtml@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
            'type' => 0,
            'ou_id' => 1,
            'state' => 0,
            'desp' => '超级管理员',
        ]);

        factory(App\Admin::class, 200)->create();

        // ->each(function ($u) {
        //     $u->posts()->save(factory(App\Post::class)->make());
        // });
    }
}

class TermsTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\Term::class, 200)->create();
    }
}

class MacsTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\Mac::class, 200)->create();
    }
}







//
