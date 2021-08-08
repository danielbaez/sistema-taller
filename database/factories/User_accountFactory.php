<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Model;
use App\Models\Branch;
use App\Models\Role;
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
        $role_id = $this->faker->numberBetween(1, Role::count());

        $branch_id = null;

        if($role_id == 2)
        {
            $branch_id = $this->faker->numberBetween(1, Branch::count());
        }

        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'role_id' => $role_id,
            'branch_id' => $branch_id,
            'status' => $this->faker->randomElement([0, 1])
        ];
    }
}
