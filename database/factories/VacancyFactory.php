<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle(),
            'amount' => $this->faker->randomDigitNotNull(),
//            'company_id' => function (array $attributes) {
//                return Company::find($attributes['id'])->company_id;
//            },
            'salary' => $this->faker->numberBetween(5000, 100000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
