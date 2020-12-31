<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Event;
use App\Models\Entry;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') === 'local') {
            for ($i = 1; $i <= 65; $i++) {
                DB::table('entries')->insert([
                    'event_id' => rand(1, 9),
                    'user_id' => $i,
                    'paid' => rand(0, 1),
                    'cancellation_request' => rand(0, 1),
                    'payment_method' => rand(1, 2),
                    'created_at' => now(),
                    'updated_at' => now(),
                    ]);
                }
        } elseif (env('APP_ENV') === 'production') {
            $events = [1, 11, 21, 31, 41, 51, 61, 71, 81];
            $users = [1, 11, 21, 31, 41, 51, 61, 71, 81, 91, 101, 111, 121, 131, 141, 151, 161, 171, 181, 191, 201, 211, 221, 231, 241, 251, 261, 271, 281, 291, 301];
            
            for ($i = 1; $i <= 65; $i++) {
                DB::table('entries')->insert([
                    'event_id' => array_rand($events, 1),
                    'user_id' => array_rand($users, 1),
                    'paid' => rand(0, 1),
                    'cancellation_request' => rand(0, 1),
                    'payment_method' => rand(1, 2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
