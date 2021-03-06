<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $circleIds = DB::table('circles')->get()->pluck('id');

        // 管理者マスター
        DB::table('users')->insert([
            'name' => '田中ユウキ',
            'email' => 'tanaka@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => $faker->phoneNumber,
            'sex' => config('const.sex.male.id'),
            'birthday' => $faker->dateTime->format('Y-m-d'),
            'circle_id' => $circleIds->random(1)->first(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 男性
        for ($i = 0; $i < 30; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'phone' => $faker->phoneNumber,
                'sex' => config('const.sex.male.id'),
                'birthday' => $faker->dateTime->format('Y-m-d'),
                'circle_id' => $circleIds->random(1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 女性
        for ($i = 0; $i < 30; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'phone' => $faker->phoneNumber,
                'sex' => config('const.sex.female.id'),
                'birthday' => $faker->dateTime->format('Y-m-d'),
                'circle_id' => $circleIds->random(1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 回答しない
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'phone' => $faker->phoneNumber,
                'sex' => config('const.sex.do_not_answer.id'),
                'birthday' => $faker->dateTime->format('Y-m-d'),
                'circle_id' => $circleIds->random(1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
