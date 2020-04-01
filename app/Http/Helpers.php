<?php

namespace App\Http;

use Illuminate\Http\Request;
use DB;
use Auth;
use Cart;

use Session;
use League\Flysystem\Exception;
use Carbon\Carbon;


class Helpers
{
	public static function has_permission($permission)
	{
		$id = Auth::user()->role_id;
		if ($id == 1)
			return 1;

		return 1;

		// $permissions=session::get('permissions');
		// if(in_array($permission,$permissions)){	return 1;}else{	return 0;}
		/*
  if(session::has('permissions'))
	  {
     	$permissions=session::get('permissions');
		if(in_array($permission,$permissions)){	return 1;}else{	return 0;}


	  }else{

	    $permissions_list=DB::table('permissions')->select('permissions.name')->Join('permission_role', function($join) use ($id)
                         {
                             $join->on('permissions.id', '=', 'permission_role.permission_id');
                             $join->on('permission_role.role_id','=',DB::raw($id));
                         })->get();

		$permissions=array();
		foreach($permissions_list as $p){$permissions[]=$p->name; }
		\Session::put('permissions',$permissions);
		if(in_array($permission,$permissions)){	return 1;}else{	return 0;}
      }
*/
	}


	public static function settings($preference)
	{

		if (session::has('system_settings')) {
			$settings = session::get('system_settings');
		} else {
			$preferences = DB::table('preferences')->where('category_id', 1)->get();
			$settings = MapColumns($preferences, 'key', 'value');
			session::put('settings', $settings);
		}

		if (isset($settings->{$preference}))
			return $settings->{$preference};
		else
			return "";
	}


	public static function update_total_amount($id)
    {


       $booking= DB::table('bookings as b')->join('master_payment_details as p','b.payment_mode_id','p.id')->select('b.*','p.is_rent_payable')->where('b.id',$id)->first();



       $food = db::table('master_settings')->orderBy('effect_from', 'desc')->first();

  
       Carbon::setWeekendDays([Carbon::SUNDAY]);
       $start  = new Carbon($booking->checkin_date);
       $end    = new Carbon($booking->checkout_date);
       $no_of_hours=$start->diffInMinutes($end)/60;
       $no_of_days = ceil($no_of_hours/24);



       if($booking->meal_needed)
       {
       $food_days_condition= $start->diffInWeekendDays($end);
       if(!$start->isWeekend() && $start->format('H.i')>21)
       {
        $food_days_condition=$food_days_condition+1;
       }

       if(!$end->isWeekend() && $end->format('H.i')<13)
        {
         $food_days_condition=$food_days_condition+1;
        }


        if(!$start->isWeekend() && !$end->isWeekend() && ( ( $start->format('H.i')<21 && $end->format('H.i')<13) || ( $start->format('H.i')>21 && $end->format('H.i')>13)) )
        {
         $food_days_condition=$food_days_condition-1;
        }
 
 
        $food_no_of_days=0;
        if($no_of_days-$food_days_condition>0)
        $food_no_of_days=$no_of_days-$food_days_condition;

        
     //   $food_amount=($food->food_amount - $booking->food_discount) * $food_no_of_days;
     //   $food_tax_amount= ($food->food_tax_percentage/100) * ($food->food_amount - $booking->food_discount) * $food_no_of_days;

     $food_amount=($food->food_amount) * $food_no_of_days;
       $food_tax_amount= ($food->food_tax_percentage/100) * ($food->food_amount) * $food_no_of_days;

    }else{

        $food_no_of_days=0;
 
        $food_amount=0;
        $food_tax_amount= 0;
     
    }




        $period_master_id = 1;
        if ($no_of_days >= 7) {
            $period_master_id = 2;
        } elseif ($no_of_days >= 30) {
            $period_master_id = 3;
        } else {
            $period_master_id = 1;
        }




        $room_rent=0;
        $room_tax_percentage=0;
        

        if ($booking->is_rent_payable==1) {
            $rooms = db::table('master_room_types as t')->join('master_room_tariff_plan as r', 'r.room_type_id', 't.id')->select('t.*', 'r.room_rent', 'r.period_master_id', 'charges_extrabed', 'tax_percentage')->where('t.status', 1)->where('r.status', 1)->where('t.id', $booking->room_type_id)->where('period_master_id', $period_master_id)->first();

            $room_rent=$rooms->room_rent;
            $room_tax_percentage=$rooms->tax_percentage;


        }

            // $room_amount=($room->room_rent - $booking->room_discount) * $no_of_days;
            //  $room_tax_amount= ($room->tax_percentage/100) * ($room->room_rent - $booking->room_discount) * $no_of_days;

            $room_amount=($room_rent) * $no_of_days;
            $room_tax_amount= ($room_tax_percentage/100) * ($room_rent) * $no_of_days;
      
      



        $total_amount=$food_amount+ $food_tax_amount+  $room_amount+ $room_tax_amount;
        $total_tax_amount=$food_tax_amount+ $room_tax_amount;

        $data=array();
        $data['food_amount'] =  $food->food_amount;
        $data['food_tax'] =  $food->food_tax_percentage;

        
        $data['food_no_of_days'] =  $food_no_of_days;
        

        $data['room_rent'] =  $room_rent;
        $data['room_tax'] =  $room_tax_percentage;



        $data['total_amount'] =  $total_amount;
        $data['total_tax_amount'] =  $total_tax_amount;
        
        
        DB::table('bookings')->where('id',$id)->update($data);


	}
  
  

  public static function sendsms($mobile,$message){
    $api_username = "aravind"; 
    $api_userpwd  = "aecstn"; 
    $send_id = "ARVIND"; 
    $curl = "https://sms.aarelit.com/SendSMS/sendmsg.php"; 

 

    $msg = $message; 
    $to = $mobile;
    $message = urlencode($msg);   
    $api_url = $curl . '?' . "uname=$api_username&pass=$api_userpwd&send=$send_id&dest=$to&msg=$message"; 
    $sms = curl_init($api_url); 
    ob_start(); 
    $ex = curl_exec($sms); 
    ob_end_clean(); 
    curl_close($sms); 

    return  $api_url;


   }



   public static function no_of_days($checkin_date,$checkout_date){
       $start  = new Carbon($checkin_date);
       $end    = new Carbon($checkout_date);
       $no_of_hours=$start->diffInMinutes($end)/60;
       return ceil($no_of_hours/24);
   }








	
}
