<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       


        $modules[]= array('name'=>'Settings','status'=>1);
        $modules[]= array('name'=>'Preferences','status'=>1);
        $modules[]= array('name'=>'Preference Categories','status'=>1);
        $modules[]= array('name'=>'Users','status'=>1);
        $modules[]= array('name'=>'User Roles','status'=>1);

        
        DB::table('module_details')->insert($modules);

        $permissions[]= array('module_id'=>'1','user_id'=>0,'role_id'=>1,'can_view'=>1,'can_add'=>1,'can_update'=>1,'can_delete'=>1);
        $permissions[]= array('module_id'=>'2','user_id'=>0,'role_id'=>1,'can_view'=>1,'can_add'=>1,'can_update'=>1,'can_delete'=>1);
        $permissions[]= array('module_id'=>'3','user_id'=>0,'role_id'=>1,'can_view'=>1,'can_add'=>1,'can_update'=>1,'can_delete'=>1);
        $permissions[]= array('module_id'=>'4','user_id'=>0,'role_id'=>1,'can_view'=>1,'can_add'=>1,'can_update'=>1,'can_delete'=>1);
        $permissions[]= array('module_id'=>'5','user_id'=>0,'role_id'=>1,'can_view'=>1,'can_add'=>1,'can_update'=>1,'can_delete'=>1);  
        
        DB::table('permissions')->insert($permissions);



    }
}
