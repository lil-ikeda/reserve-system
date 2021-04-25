<?php

use Illuminate\Database\Seeder;
use Carbon\CarbonImmutable;

class CircleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = CarbonImmutable::now();
        $data = [];
        $circles = [
            'Dig Up Treasure',
            'Fusion Of Gumbit',
            "S'il vous plait!",
            "乱縄",
            "DSP",
            "D-act",
            "mix-package",
            "鴇縄",
            "佛跳",
            'その他'
        ];

        foreach($circles as $circle) {
            $data[] = [
                'name' => $circle,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('circles')->insert($data);
    }
}
