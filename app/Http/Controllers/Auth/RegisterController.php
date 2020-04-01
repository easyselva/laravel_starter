<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
           
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
       
        ]);
    }


    public function register(Request $request)
    {

      
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           // 'password' => ['required', 'string', 'min:6'],
            'mobile_no' => ['required', 'string', 'unique:users'],
            'display_name' => ['required', 'string'],
        ]);
  
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

     


        $user = User::create([
            'user_name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make(mt_rand(100000, 999999)),
            'role_id' => '3' ,
            'display_name' =>  $request->display_name,
            'mobile_no' => $request->mobile_no,
            'status' =>1,
        ]);;

        $otp = mt_rand(100000, 999999);
     
        $user->otp_no = $otp;
        $user->save();

        session(['user_id' => $user->id]);

         Mail::to($user)->queue(new SendOTP($user));
       
        //event(new Registered($user));

     //   Auth::login($user);

        


        if ($request->ajax()) {
            return array('status' => true, 'notification' => 'OTP Sent to your email');
        }else{
            return redirect()->intended($this->redirectPath());
        }



    

    }


    
 public function showRegistrationForm(Request $request)
 {
     if ($request->ajax()) {
 
         $rows = collect($this->get_rows('', 'create'));
         $collection = collect(['form_type' => 'Create', 'url' => route('ajax_register'), 'form_name' => 'user', 'display_name' => 'Register','custom_submit_button'=>"Register"]);
 
         return view('auth.ajax_register')->with(['collection' => $collection, 'rows' => $rows, 'modal_class' => '']);
    
     }else{

        return redirect()->route('home')->with('status', 'Please Login to see the requested page');
    
     }


 }
 
 
 public function get_rows($model, $form_type)
 {
    
     $i = 0;
     $rows[$i][] = array('field_name' => 'display_name', 'label_name' => 'Name', 'field_type' => 'text', 'placeholder' => 'Enter your name', 'class_name' => 'required');

     $i++;
    
     $rows[$i][] = array('field_name' => 'email', 'label_name' => 'email', 'field_type' => 'text', 'placeholder' => 'Enter your email', 'class_name' => 'required email', 'id' => 'email');

     $i++;
    
     $rows[$i][] = array('field_name' => 'mobile_no', 'label_name' => 'Mobile No', 'field_type' => 'text', 'placeholder' => 'Enter your mobile no', 'class_name' => 'required', 'id' => 'email');


   
 
     return $rows;
 }

 



}
