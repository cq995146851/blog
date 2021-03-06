<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 50)->times(50)->make();
        User::insert($users->makeVisible(['password',
            'remember_token'])->toArray());
        $user = User::find(1);
        $user->name = '陈骞';
        $user->email = '995146851@qq.com';
        $user->activation_token = '';
        $user->activated = true;
        $user->is_admin = true;
        $user->save();
    }
}
