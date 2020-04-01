<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;

use App\Models\User;
use Auth;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            if ($request->ajax()) {
                return array('status' => false, 'notification' => 'Max attempt Completed! Please contact Administrator');
            } else {

                return redirect('login')
                    ->with('error', 'Max attempt Completed! Please contact Administrator')
                    ->withInput($request->only('user_name'));
            }
        }



        $logValue = $request->user_name;

        $logAccess = filter_var($logValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        $credentials = [
            $logAccess  => $logValue,
            'password'  => $request->input('password'),
        ];

        // $this->validate($request, ['username' => 'required', 'password' => 'required',]);


        if (!auth()->validate($credentials)) {

            if (!$lockedOut) {
                $this->incrementLoginAttempts($request);
            }


            if ($request->ajax()) {
                return array('status' => false, 'notification' => 'Check your username and Password');
            }



            return redirect('login')
                ->withInput($request->only('user_name', 'remember'))
                ->withErrors(['user_name' => "Check your username and Password"]);
        }

        $user = auth()->getLastAttempted();



        if ($user) {
            $this->guard()->login($user);
            if ($request->ajax()) {
                return array('status' => true, 'notification' => 'Login Success', 'content' => view('login_status')->render());
            } else {
                return redirect()->intended($this->redirectPath());
            }
        }
    }


    public function showLoginForm(Request $request)
    {
        if ($request->ajax()) {

            return view('auth.ajax_login');
        } else {

          //  return redirect()->route('home')->with('status', 'Please Login to see the requested page');
    

            return view('auth.login');
        }
    }

    public function showOTPForm(Request $request)
    {

        if ($request->ajax()) {


            return view('auth.ajax_otp');
        } else {

            return view('auth.login');
        }
    }



    public function getOTP(Request $request)
    {
        
   

        $validator = Validator::make($request->all(), [
            'email' => 'email|required',

        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $otp = mt_rand(100000, 999999);
        $user = User::where('email', $request->email)->first();
        if (!isset($user->email)) {
            return array('status' => false, 'notification' => 'Please register your email first', 'content' => 'REGISTER');
        }
        $user->otp_no = $otp;
        $user->save();

        session(['user_id' => $user->id]);

   
         
         Mail::to($user)->queue(new SendOTP($user));
         
         
        return array('status' => true, 'notification' => 'OTP has been sent to your email', 'content' => 'OTP');
    }



    public function submitOTP(Request $request)
    {

        $user = User::where('id', session('user_id'))->first();

        if (!isset($user->email)) {
            return array('status' => false, 'notification' => 'Session Expired. Refresh your page');
        }

        if ($user->otp_no == $request->otp) {
            Auth::login($user);
            return array('status' => true, 'notification' => 'Login Success', 'content' => view('login_status')->render());
        } else {

            return array('status' => false, 'notification' => 'Please check OTP');
        }
    }


    public function get_rows($model, $form_type)
    {
        $i = 0;
        $rows[$i][] = array('field_name' => 'email', 'label_name' => 'Enter your Email / Mobile No', 'field_type' => 'text', 'placeholder' => 'Enter User Name', 'class_name' => 'required email');
        return $rows;
    }
}
