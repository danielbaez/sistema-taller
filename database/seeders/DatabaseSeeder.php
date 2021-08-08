<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\User;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User_account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        Branch::factory(3)->create();

        User::factory()
        ->create(['username' => 'daniel', 'name' => 'Daniel Baez', 'email' => 'daniel@gmail.com', 'status' => 1])
        ->each(function($user) {
        	$this->add_user_accounts(3, $user);
        });

        User::factory(10)
        ->create()
        ->each(function($user) {
        	$this->add_user_accounts(3, $user);
        });

        /*Log::create([
            'user_id' => 1,
            'role_id' => 1,
            'branch_id' => 1,
            'description' => 'text',
            'status' => 1,
            'created_at' => '2020-02-02 11:11:11'
        ]);*/
    }

    public function add_user_accounts($number, $user)
    {
    	$user_account = User_account::factory($number)->make(['user_id' => $user->id]);

    	foreach($user_account as $key => $value)
    	{
    		$count = User_account::where('user_id', $value->user_id)
        	->where('role_id', $value->role_id)
        	->where('branch_id', $value->branch_id)
        	->count();

        	if($count == 0)
        	{
                /*$data = $value->toArray();
                $data['status'] = array_search($value->status, config('system.status'), true);

        		User_account::create($data);*/

                User_account::create($value->toArray());	
        	}	
    	}
    }
}
