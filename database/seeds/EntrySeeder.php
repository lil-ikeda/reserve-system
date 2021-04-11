<?php

use App\Helpers\Helper;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use Carbon\CarbonImmutable;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventIds = Event::get()->pluck('id');
        $userIds = User::get()->pluck('id');
        $now = CarbonImmutable::now();

        $data = [];
        foreach ($eventIds as $eventId) {
            foreach ($userIds as $userId) {
                if (Helper::setPercentage(50)) {
                    $data[] = [
                        'event_id' => $eventId,
                        'user_id' => $userId,
                        'paid' => rand(0, 1),
                        'cancellation_request' => rand(0, 1),
                        'payment_method' => rand(1, 2),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];    
                }
            }
        }

        DB::table('entries')->insert($data);
    }
}
