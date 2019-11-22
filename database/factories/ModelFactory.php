<?php
use Faker\Generator;
use App\User;
use App\Client;
use App\Address;

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

$factory->define(User::class, function (Generator $faker) {
    return [
        'name'  => $faker->name,
        'email' => $faker->email,
    ];
});


$factory->define(Client::class, function(Generator $faker) {
    return [
        'name'  => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber
    ];
});

$factory->define(Address::class, function(Generator $faker) {
    return [
        'address' => $faker->address,
        'city'    => $faker->city,
        'state'   => $faker->state,
        'zipcode' => $faker->postcode
    ];

});
