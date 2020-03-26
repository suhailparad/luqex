<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name'=>'Luqex.com',
            'email'=>'admin@luqex.com',
            'password'=>bcrypt('Luqex@123*'),
            'role'=>'admin']);

        DB::table('packages')->insert([
            'name'=>'Free Tier',
            'description'=>'Unlimited Access',
            'price'=>"0"]);
    }
}
