<?php

use Illuminate\Database\Seeder;
use App\GraphicContact;

class GraphicContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GraphicContact::truncate();

        $faker = \Faker\Factory::create();

        for ($i=0; $i < 50; $i++) { 
            GraphicContact::create([
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
