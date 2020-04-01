<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Helpers;



class SettingsController extends Controller
{
    public $module_id;

    public function __construct()
    {
        $this->middleware('auth');
        $this->module_id=1;
    }

	public function index()
    {

        if (!Helpers::has_permission($this->module_id.'_view')) {
            return array('status' => false, 'notification' => "No permission!");
        }

          $preferences = DB::table('preferences')->where('category_id', 1)->get();
          $settings = MapColumns($preferences, 'key', 'value');
          return view('settings.index')->with('settings', $settings);
      

    }

	public function update(Request $request)
    {
        
        if (!Helpers::has_permission($this->module_id.'_update')) {
            return array('status' => false, 'notification' => "No permission!");
        }

        $post = $request->except('login_logo','dashboard_logo','favicon');
        $i = 0;
        foreach ($post as $key => $value) {
            $data['value'] = $value;
            DB::table('preferences')->updateOrInsert(['category_id' => 1, 'key'=>$key],$data);     
        }

        $images=array('login_logo','dashboard_logo','favicon','login_background');
        for($i=0;$i<count($images);$i++)
        {
            $data=[];
            $file = $request->file($images[$i]);
            if (isset($file)) {
               $path = $request->file($images[$i])->store('settings');
               $data['value'] =$path;
               Storage::setVisibility($path, 'public' );
               DB::table('preferences')->updateOrInsert(['category_id' => 1, 'key'=>$images[$i]],$data);
           }
        }

        return redirect()->route('settings')->with('success', 'Settings successfully Updated');

    }







}
