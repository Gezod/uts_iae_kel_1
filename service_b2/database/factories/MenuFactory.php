<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;


    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['food', 'drink']),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'photo' => 'images/menu/' . $this->faker->randomElement([
                'drink1.jpg',
                'drink2.jpg',
                'drink3.jpg',
                'drink4.jpg',
                'drink5.jpg',
                'food1.jpg',
                'food2.jpg',
                'food3.jpg',
                'food4.jpg',
                'food5.jpg',
            ]),
        ];
    }
}

