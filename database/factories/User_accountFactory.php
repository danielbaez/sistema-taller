<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Model;
use App\Models\Branch;
use App\Models\Profile;
use App\Models\User_account;
use Illuminate\Database\Eloquent\Factories\Factory;

class User_accountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User_account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $profile_id = $this->faker->numberBetween(1, Profile::count());

        $branch_id = null;

        if($profile_id == 2)
        {
            $branch_id = $this->faker->numberBetween(1, Branch::count());
        }

        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'profile_id' => $profile_id,
            'branch_id' => $branch_id,
            'status' => $this->faker->randomElement([0, 1])
        ];
    }
}
