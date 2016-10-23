<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create(array(
            'name'     => 'Endro Ngujiharto',
            'email'    => 'ndro.indi90@gmail.com',
            'is_admin' => 1,
            'password' => Hash::make('12345678'),
        ));

        $users = factory(App\User::class, 10)->create();
        foreach ($users as $user){
            \App\User::create(array(
                'name'     => $user->name,
                'email'    => $user->email,
                'is_admin' => $user->is_admin,
                'password' => $user->password,
            ));
        }
    }
}
