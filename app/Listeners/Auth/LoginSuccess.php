<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

use DB;

class LoginSuccess
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

       // $academic_session=DB::table('academic_sessions')->where('is_current',1)->first();
       // if(isset($academic_session->id))
       // session(['academic_session_id' => $academic_session->id,'academic_session' => $academic_session->name]);

        session(['role' => $user->role_id]);
    }
}
