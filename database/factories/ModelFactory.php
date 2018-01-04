<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Admin::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
        'type' => rand(0, 3),
        'ou_id' =>  rand(1, 3),
        'state' => rand(0, 1),
        'desp' => '',
    ];
});

$factory->define(App\Mac::class, function (Faker\Generator $faker) {
    $nicvendor = ['dell','xiaomi','apple', 'huawei', 'intel', 'meizu','cisco','hewlett','vmware'];
    return [
        'mac' => $faker->unique()->macAddress,
        'ip' => $faker->unique()->ipv4,
        'nicvendor' => $nicvendor[array_rand($nicvendor, 1)],
        'term_id' => rand(1, 200),
    ];
});

$factory->define(App\Term::class, function (Faker\Generator $faker) {
    $os = ['window xp', 'window 7', 'window 8', 'window 10', 'mac os', 'ios', 'android'];
    return [
        'name' => $faker->unique()->name,
        'type' => rand(1, 7),
        'ou_id' => rand(1, 3),
        'hostname' => $faker->city,
        'os' => $os[array_rand($os, 1)],
        'user_id' => rand(1, 100),
        'state' => rand(0, 3),
        'desp' => '',
    ];
});
