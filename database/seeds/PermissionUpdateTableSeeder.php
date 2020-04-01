<?php

use Illuminate\Database\Seeder;

class PermissionUpdateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $modules[]= array('name'=>'Settings','status'=>1); //1
        $modules[]= array('name'=>'Preferences','status'=>1); //2
        $modules[]= array('name'=>'Preference Categories','status'=>1); //3
        $modules[]= array('name'=>'User Roles','status'=>1); //4
        $modules[]= array('name'=>'Users','status'=>1); //5
       
        
        
        DB::table('module_details')->truncate();
        DB::table('module_details')->insert($modules);

    }
}
