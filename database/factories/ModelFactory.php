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

$factory->define(App\Http\Resources\Feed::class, function (Faker\Generator $faker) {
    return [
        '_id' => Ramsey\Uuid\Uuid::uuid4(),
        'name' => $faker->words(2, true),
        'link' => $faker->url,
        'feed' => $faker->url,
        'title' => $faker->title,
        'description' => $faker->sentence,
        'properties' => [
            'name' => "$faker->firstName, $faker->lastName",
            'username' => $faker->userName,
        ],
    ];
});
