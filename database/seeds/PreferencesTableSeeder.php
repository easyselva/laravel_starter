<?php

use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
	public function run()
    {

        $category[]=array('name'=>"Settings");
   
        DB::table('preference_categories')->truncate();
        DB::table('preference_categories')->insert($category);

        $pre[]=array('category_id'=>1, 'key'=>"site_full_name",'value'=>"SERV BUDDY");
        $pre[]=array('category_id'=>1, 'key'=>"site_short_name",'value'=>"SB");
        $pre[]=array('category_id'=>1, 'key'=>"email_id",'value'=>"selva@servbuddy.com");
        $pre[]=array('category_id'=>1, 'key'=>"website",'value'=>"servbuddy.com");
        $pre[]=array('category_id'=>1, 'key'=>"phone",'value'=>"9952732367");
        $pre[]=array('category_id'=>1, 'key'=>"street",'value'=>"Address line1");
        $pre[]=array('category_id'=>1, 'key'=>"city",'value'=>"Sivakasi");
        $pre[]=array('category_id'=>1, 'key'=>"state",'value'=>"Tamilnadu");
        $pre[]=array('category_id'=>1, 'key'=>"country",'value'=>"India");
        $pre[]=array('category_id'=>1, 'key'=>"pincode",'value'=>"626103");
        $pre[]=array('category_id'=>1, 'key'=>"dashboard_logo",'value'=>"assets/media/logo.png");
        $pre[]=array('category_id'=>1, 'key'=>"login_logo",'value'=>"assets/media/main_logo.png");
        $pre[]=array('category_id'=>1, 'key'=>"favicon",'value'=>"assets/media/favicon.png");
        $pre[]=array('category_id'=>1, 'key'=>"login_background",'value'=>"assets/media/login_background.jpg");
     

        DB::table('preferences')->insert($pre);



    }
}
