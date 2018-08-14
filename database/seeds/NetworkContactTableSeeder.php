<?php

use Illuminate\Database\Seeder;
use App\NetworkContact;

class NetworkContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NetworkContact::truncate();

        $faker = \Faker\Factory::create();

        for ($i=0; $i < 50; $i++) { 
            NetworkContact::create([
                'subject' => $faker->sentence,
                'name' => $faker->name,
                'phone' => '4422',
                'email' => $faker->email,
                'is_seen' => 0,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
