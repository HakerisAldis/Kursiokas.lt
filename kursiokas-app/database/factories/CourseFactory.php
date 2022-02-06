<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$tmp = explode('/', $this->faker->image('./public/images', 640, 480, 'humans'));
		$image = "images/" . end($tmp);

        return [
            'name' => $this->faker->realText(30, 1),
			'date' => date_format($this->faker->dateTimeInInterval('now', '+1 years'), 'Y-m-d'),
			'time' => $this->faker->time('H:i', 'now'),
			'seats' => $this->faker->numberBetween(25, 500),
			'address' => $this->faker->address(),
			'price' => $this->faker->randomFloat(2, 5, 100),
			'scope' => $this->faker->jobTitle(),
			'image' => $image,
			'description' => $this->faker->realText(1000, 1),
			'city' => $this->faker->city()
        ];
    }
}
