<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /** @var Animal $cat */
        Animal::factory()->create([
            'avatar' => asset('images/animals/cat.png'),
            'type' => 'cat',
            'max_size' => 15,
            'min_size' => 1,
            'max_age' => 9999,

            'growth_rate' => 1
        ]);

        Animal::factory()->create([
            'avatar' => asset('images/animals/bird.png'),
            'type' => 'bird',
            'max_size' => 10,
            'min_size' => 1,
            'max_age' => 15,

            'growth_rate' => 1
        ]);

        Animal::factory()->create([
            'avatar' => asset('images/animals/dog.png'),
            'type' => 'dog',
            'max_size' => 25,
            'min_size' => 4,
            'max_age' => 13,

            'growth_rate' => 1.5
        ]);

        Animal::factory()->create([
            'avatar' => asset('images/animals/cavy.png'),
            'type' => 'cavy',
            'max_size' => 15,
            'min_size' => 4,
            'max_age' => 6,

            'growth_rate' => 2
        ]);
    }
}
