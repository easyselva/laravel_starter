<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Helpers;
use DataTables;
use Carbon\Carbon;
use Validator;
use Session;
use Auth;


class RoleController extends Controller
{
    public $module_id;


    public function __construct()
    {
        $this->middleware('auth');
        $this->module_id=4;
    }

    public function index(Request $request)
    {

        if (!Helpers::has_permission($this->module_id.'_view')) {
                return array('status' => false, 'notification' => "No permission!");
        }


        if ($request->ajax()) {
            return $this->show_data();
        } else {
            return view('index')->with($this->get_data());
        }

        
    }

    public function show_data()
    {
        $students = DB::table('roles');
        $datatables = Datatables::of($students);

        $can_update=0;$can_delete=0;

        if (Helpers::has_permission($this->module_id.'_update')) {
            $can_update=1;
        }
        if (Helpers::has_permission($this->module_id.'_delete')) {
            $can_delete=1;
        }

        
        $datatables->addColumn('action', function ($sdata) use ($can_delete,$can_update) {
            $action='<span class="dropdown">
        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
          <i class="la la-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >';

            if ($can_update==1) {
            
            $action=$action.'<a  class="dropdown-item ajax-popup" href="' . route("roles.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit Details</a>';
      
            $action=$action.'<a  class="dropdown-item ajax-popup" href="' . route("permissions", ['role',$sdata->id]) . '"><i class="la la-edit"></i> Edit Permissions</a>';
            
        }

        if($can_delete==1)
        $action=$action.'<a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>';

        $action=$action.'</div></span>';

        return $action;

        });



        return $datatables->make(true);

    }

    public function get_data()
    {
        $data['title']="User Roles";
        $data['data_url']=route('roles.index');

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"name", 'name'=>"name",'display_name'=>"Role Name");
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['module_id'] = $this->module_id;
        $data['create_url'] = route('roles.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('roles.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {

        if (!Helpers::has_permission($this->module_id.'_add')) {
              return array('status' => false, 'notification' => "No permission!");
        }


        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=>'admin/roles','module_id'=>$this->module_id,'display_name'=>'Role']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {

        if (!Helpers::has_permission($this->module_id.'_add')) {
            return array('status' => false, 'notification' => "No permission!");
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('name');
        $child['updated_at']= $current;
        DB::table('roles')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Exam successfully added.",
            );
        } 
        return redirect()->route('roles.index')->with('message', 'Role details successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {

        if (!Helpers::has_permission($this->module_id.'_update')) {
              return array('status' => false, 'notification' => "No permission!");
        }


        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $role = DB::table('roles')->where('id',$id)->first();
        $rows = collect($this->get_rows($role, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'roles','module_id'=> $this->module_id ,'display_name'=>'Role']);
        return view($view)->with(['model_name' => $role, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {
        $i=0;
        $rows[$i][0] = array('field_name' => 'name', 'label_name' => 'Role Name', 'field_type' => 'text', 'placeholder' => 'Enter Role Name', 'class_name' => 'required');
       
        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        if (!Helpers::has_permission($this->module_id.'_update')) {
            return array('status' => false, 'notification' => "No permission!");
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('name');
        $child['updated_at']= $current;
        DB::table('roles')->where('id',$id)->update($child);


       
        



        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Role details successfully updated...");
        } 

        return redirect(route('roles.index'))->with('message','Role details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        if (!Helpers::has_permission($this->module_id.'_delete')) {
            return array('status' => false, 'notification' => "No permission!");
        }

        DB::table('roles')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Role Details successfully deleted.");
        }


        return redirect(route('roles.index'))->with('message','Role details successfully Deleted...!');
    }


    public function permissions(Request $request,$type,$id)
    {
        if (!Helpers::has_permission($this->module_id.'_update')) {
            return array('status' => false, 'notification' => "No permission!");
        }
    
        $collection = collect(['url'=>  route("permissions", [$type,$id]) ,'module_id'=>$this->module_id]);

        
        $modules=DB::TABLE('module_details')->leftJoin('permissions',function($join) use ($id,$type){

            if($type=="role")
            $join->on('permissions.module_id','module_details.id')->where('permissions.role_id',$id);
            else 
            $join->on('permissions.module_id','module_details.id')->where('permissions.user_id',$id);



        })->select('module_details.*','permissions.can_view','permissions.can_add','permissions.can_update','permissions.can_delete')->get();





        return view('permissions')->with(['modal_class' => 'modal-lg','collection'=>$collection,'modules' => $modules ]);


      
    }



 public function update_permissions(Request $request,$type,$id)
    {
        if (!Helpers::has_permission($this->module_id.'_update')) {
            return array('status' => false, 'notification' => "No permission!");
        }
    
               
        $modules=$request->module_id;
         
        for($i=0;$i<count($modules);$i++)
        {

            $current = Carbon::now();

            $q=array();
            $q['module_id']=$modules[$i];
            
            if ($type=="role") {
                $q['role_id']=$id;
                $q['user_id']=0;
            }
            else{
                $q['user_id']=$id;
                $q['role_id']=0;
            }

            if(isset($request->{ 'can_view_'.$modules[$i]}))
            $data['can_view']= 1;
            else 
            $data['can_view']= 0;
            

            if(isset($request->{ 'can_add_'.$modules[$i]}))
            $data['can_add']= 1;
            else 
            $data['can_add']= 0;
            
            if(isset($request->{ 'can_update_'.$modules[$i]}))
            $data['can_update']= 1;
            else 
            $data['can_update']= 0;
            
            if(isset($request->{ 'can_delete_'.$modules[$i]}))
            $data['can_delete']= 1;
            else 
            $data['can_delete']= 0;
            


          
            DB::table('permissions')->updateOrInsert($q, $data);




        }



        $role_id = Auth::user()->role_id;
		$user_id = Auth::user()->id;
	    $permissions_list=DB::table('permissions')->where('user_id',$user_id)->orWhere('role_id',$role_id)->get();

		$permissions=array();
		foreach($permissions_list as $p)
		{
		
			if($p->can_view==1)
			$permissions[]=$p->module_id."_view";
			if($p->can_add==1)
			$permissions[]=$p->module_id."_add";
			if($p->can_update==1)
			$permissions[]=$p->module_id."_update";
			if($p->can_delete==1)
			$permissions[]=$p->module_id."_delete";
		
		}
        Session::put('permissions',$permissions);



        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Permission updated.");
        }


        return redirect(route('roles.index'))->with('message','Permission updated.');
      

      
    }



}
