<?php

use Illuminate\Database\Seeder;

class UpdatePasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $users=DB::table('users')->where('role_id',2)->get();


        foreach ($users as $user) {
            if ($user) {
                  DB::table('users')->where('id', $user->id)->update(['password'=>bcrypt($user->mobile_no)]);
               }
       }


    }
}
