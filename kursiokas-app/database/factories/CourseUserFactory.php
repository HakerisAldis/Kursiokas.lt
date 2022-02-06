<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Enums\UserType;

class CourseUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$courseEntries = DB::select('select * from courses');
		$userEntries = DB::select('select * from users where type=' . UserType::Member . ';');

		$courseCount = count($courseEntries);
		$userCount = count($userEntries);

        return [
            'course_id' => $courseEntries[$this->faker->numberBetween(0, $courseCount - 1)]->id,
			'user_id' => $userEntries[$this->faker->numberBetween(0, $userCount - 1)]->id
        ];
    }
}
