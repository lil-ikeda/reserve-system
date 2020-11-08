<?php

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 10; $i++) {
            Event::create([
                'name' => 'イベント'.$i,
                'description' => 'イベントの詳細'.$i,
                'date' => '2020-0'.$i.'-01',
                'open_time' => '10:00',
                'close_time' => '22:00',
                'place' => '開催場所'.$i,
                'price' => $i,
            ]);
        }
    }
}
