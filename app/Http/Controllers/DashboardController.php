<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Response;
use DB;
use DataTables;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Hash;
use Storage;

use Config;


use Notification;
use App\Notifications\GeneralNotification;



class DashboardController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function sendNotification()
    {
       /* $user = User::first();
  
        $details = [
            'greeting' => 'Hi Artisan',
            'body' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101
        ];
  
        Notification::send($user, new GeneralNotification($details));
   
        dd('done');
        
        */

       dd(Config::get('mail'));


    }




    public function index(Request $request)
    {

        
        $data=array();
        return view('welcome')->with($data);
        

    }

    public function show_data($table_name,$route_name)
    {
        $datas = DB::table($table_name);
        $datatables = Datatables::of($datas);

        return $datatables->addColumn('action',function($data)  use ($route_name){
            return '<a href="' . route($route_name,$data->id) . '" class="btn btn-sm btn-primary"><i class="la la-edit"></i></a>';
        })->make(true);

    }


    public function change_password(Request $request)
    {
        return view('change_password');
    }



    
    public function update_password(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Hash::check($_POST['old_password'],$user->password) && $_POST['new_password'] <> "") {
            $user->password = bcrypt($_POST['new_password']);
            $user->save();
            return 1;
        } else {
            return "Check your Old Password";
        }
    }

    public function download(Request $request)
    {
        return Storage::download($request->file_location);
    }



}
