<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'document_type' => 'RUC',
            'document_number' => $this->faker->numberBetween(10000000000, 99999999999),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'representative' => $this->faker->name,
            'status' => $this->faker->randomElement([0, 1])
        ];
    }
}
