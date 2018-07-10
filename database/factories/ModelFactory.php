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
$factory->define(
    App\Models\Role::class,
    function (Faker\Generator $faker) {
        static $password;

        return [
            'title' => $faker->word,
            'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
            'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
);
$factory->define(
    App\Models\User::class,
    function (Faker\Generator $faker) {
        static $password;

        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => str_random(10),
            'last_login' => $faker->date('Y-m-d H:i:s', 'now'),
            'last_logout' => $faker->date('Y-m-d H:i:s', 'now'),
            'role_id' => function () {
                return factory('App\Models\Role')->create()->id;
            },
        ];
    }
);
$factory->define(
    App\Models\Competition::class,
    function ($faker) {
        $header      = $faker->sentence;
        $info        = $faker->sentence;
        $start_date  = $faker->date('d.m.Y', 'now');
        $timetable_1 = $faker->date('d.m.Y', 'now');

        return [
            'organizer_id' => function () {
                return factory('App\Models\User')->create()->id;
            },
            'header' => $header,
            'timetable_1' => $timetable_1,
            'register' => 0,
            'award' => 'Urkunden',
            'info' => $info,
            'season' => 'bahn',
            'start_date' => $start_date,
            'submit_date' => $start_date,
            'classes' => 'Frauen',
            'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
            'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
            'created_by' => 1,
            'updated_by' => 1,
            'only_list' => 0,
            'ignore_ageclasses' => 1,
            'ignore_disciplines' => 1,
        ];
    }
);
$factory->define(
    App\Models\Additional::class,
    function (Faker\Generator $faker) {
        return [
            'competition_id' => function () {
                return factory('App\Models\Competition')->create()->id;
            },
            'created_by' => function () {
                return factory('App\Models\User')->create()->id;
            },
            'updated_by' => function () {
                return factory('App\Models\User')->create()->id;
            },
            'value'  => $faker->name,
            'key'  => $faker->name,
            'mnemonic'  => $faker->name
        ];
    }
);

$factory->define(
    App\Models\Activity::class,
    function (Faker\Generator $faker) {
        return [
            'user_id' => auth()->id(),
            'subject_id' => 1,
            'subject_type' => 'App\Model\Competition',
            'type' => 'created',
            'component' => 'competition',
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ];
    }
);


$factory->define(
    App\Models\Address::class,
    function (Faker\Generator $faker) {
        return [
            'name' => $faker->name,
            'telephone' => $faker->phoneNumber,
            'fax' => $faker->phoneNumber,
            'street' => $faker->streetAddress,
            'zip' => $faker->postcode,
            'city' => $faker->city,
            'email' => $faker->email,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ];
    }
);