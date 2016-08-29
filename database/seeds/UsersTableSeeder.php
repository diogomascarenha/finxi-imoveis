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
        DB::table('users')->insert([
            [
                'name'           => 'Diogo Oliveira Mascarenhas',
                'email'          => 'diogomascarenha@gmail.com',
                'password'       => bcrypt('123456'),
                'remember_token' => str_random(10),
                'created_at'     => \Carbon\Carbon::now()
            ]
        ]);
    }
}
