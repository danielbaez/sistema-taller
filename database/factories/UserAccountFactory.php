<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Model;
use App\Models\Branch;
use App\Models\Role;
use App\Models\UserAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roleId = $this->faker->numberBetween(1, Role::count());

        $branchId = null;

        if($roleId == 2)
        {
            $branchId = $this->faker->numberBetween(1, Branch::count());
        }

        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'role_id' => $roleId,
            'branch_id' => $branchId,
            'status' => $this->faker->randomElement([0, 1])
        ];
    }
}
