<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;


class AuthController extends Controller
{
   
    public function index()
    {
        return response()->json(['status' => 200, 'version' => '1.0']);
    }

    public function authenticate(Request $request)
    {
            $credentials = $request->only('user_name', 'password');

            try {
                if (! $token = auth('api')->attempt($credentials)) {
                    return response()->json(['error' => 'Invalid Credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'Could not create token'], 500);
            }

           $update=DB::table('users')->where('users.id',auth('api')->user()->id)->update(['device_id'=> $request->device_id]);

           $academic_session=DB::table('academic_sessions')->where('is_current',1)->first();
           $academic_session_id =$academic_session->id;
           $sdata = DB::table('users')->join('user_students', 'user_students.student_id', 'users.id')->leftJoin('user_student_enrolls', function ($join) use ($academic_session_id) {
            $join->on('user_student_enrolls.student_id', 'users.id');
            $join->where('user_student_enrolls.academic_session_id', $academic_session_id);
           })->leftJoin('class_details', 'class_details.id', 'user_student_enrolls.class_id')->where('users.role_id', 2)->select('users.id','mobile_no','email','image_location', 'class_details.grade', 'user_students.*' ,'class_details.section')->where('users.id',auth('api')->user()->id)->first();


           $brothers=DB::table('users')->select('id','first_name as name')->where('mobile_no',auth('api')->user()->mobile_no)->where('id','<>',auth('api')->user()->id)->get();

            $data = collect($sdata);
            $data->put('token', $token);
            $data->put('brothers', $brothers);
            

            $data->put('image_location', url('api/photo?filename='.$sdata->image_location)) ;

            return response()->json([
               // 'token' => $token,
                'user' => $data,
                'token_type' => 'bearer',
                'expiredAt' => auth('api')->factory()->getTTL() * 60
            ]);


    }

  

    public function getAuthenticatedUser()
            {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }


            public function switchUser(Request $request)
            {
                  
                $user_id=$request->user_id;
                $user = User::where('id', $user_id)->first();
                try {
    
                    if ($user) {
                    if (! $token = auth('api')->fromUser($user)) {
                        return response()->json(['error' => 'Invalid Credentials'], 400);
                    }
                    }else{
                        return response()->json(['error' => 'Invalid Credentials'], 400);
                    }
                } catch (JWTException $e) {
                    return response()->json(['error' => 'Could not create token'], 500);
                }


          

    
               $update=DB::table('users')->where('users.id',$user_id)->update(['device_id'=> $request->device_id]);
    
               $academic_session=DB::table('academic_sessions')->where('is_current',1)->first();
               $academic_session_id =$academic_session->id;
               $sdata = DB::table('users')->join('user_students', 'user_students.student_id', 'users.id')->leftJoin('user_student_enrolls', function ($join) use ($academic_session_id) {
                $join->on('user_student_enrolls.student_id', 'users.id');
                $join->where('user_student_enrolls.academic_session_id', $academic_session_id);
               })->leftJoin('class_details', 'class_details.id', 'user_student_enrolls.class_id')->where('users.role_id', 2)->select('users.id','mobile_no','email','image_location', 'class_details.grade', 'user_students.*' ,'class_details.section')->where('users.id',$user_id)->first();
    
    
               $brothers=DB::table('users')->select('id','first_name as name')->where('mobile_no',$sdata->mobile_no)->where('id','<>',$user_id)->get();
    
                $data = collect($sdata);
                $data->put('token', $token);
                $data->put('brothers', $brothers);
                
    
                $data->put('image_location', url('api/photo?filename='.$sdata->image_location)) ;
    
                return response()->json([
                   // 'token' => $token,
                    'user' => $data,
                    'token_type' => 'bearer',
                    'expiredAt' => auth('api')->factory()->getTTL() * 60
                ]);

                

            }


}
