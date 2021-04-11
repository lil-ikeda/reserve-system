<?php

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Faker\Factory;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create(config('app.faker_locale'));
        $now = CarbonImmutable::now();
        $data = [];

        for ($i = 1; $i < 100; $i++) {
            $date = $faker->dateTimeBetween('now', '+60days')->format('Y-m-d');

            $data[] = [
                'name' => $faker->sentence,
                'description' => $faker->text,
                'date' => $date,
                'open_time' => rand(10, 13).':00',
                'close_time' => rand(17, 21).':00',
                'place' => $faker->address,
                'price' => rand(0, 200),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('events')->insert($data);
    }
}
