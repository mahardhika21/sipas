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
        //

        \App\User::create([
        'name'  => 'PT.Transisi Teknologi Mandiri',
        'email' => 'admin@transisi.id',
        'password'  => bcrypt('transisi')
		]);
    }
}
