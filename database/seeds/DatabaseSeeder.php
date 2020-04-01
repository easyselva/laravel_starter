<?php

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
      //  DB::table('roles')->truncate();
        DB::table('roles')->insert([['name' => 'Super Admin'],['name' => 'Admin'],['name' => 'Customer']]);


		$user = array('email'=>'admin@example.com',
                'password'=> bcrypt('12345'),
                'user_name'=>'admin'
                ,'display_name'=>'admin'
                ,'role_id'=>1
                ,'status'=>1,
        );
     //   DB::table('users')->truncate();
        DB::table('users')->insert($user);


       


        
		$this->call(PreferencesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
     
    }
}
