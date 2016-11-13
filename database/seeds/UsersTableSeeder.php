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
        factory(\VueFin\User::class, 1)
            ->states('admin')->create([
                'name'  => 'Thiago M.',
                'email' => 'thiago.mori@gmail.com'
            ]);
    }
}
