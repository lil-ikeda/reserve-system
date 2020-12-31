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
        // 全イベントIDを配列にいれる
        $events = [];
        foreach (Event::all() as $event) {
            $events[] = $event->id;
        }

        // 全ユーザーIDを配列にいれる
        $users = [];
        foreach (User::all() as $user) {
            $users[] = $user->id;
        }

        for ($i = 1; $i <= 65; $i++) {
            DB::table('entries')->insert([
                'event_id' => $events[array_rand($events, 1)],
                'user_id' => $users[array_rand($users, 1)],
                'paid' => rand(0, 1),
                'cancellation_request' => rand(0, 1),
                'payment_method' => rand(1, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
