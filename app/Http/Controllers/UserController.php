<?php
namespace App\Http\Controllers;
use App\Http\Helpers;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Response;
use Storage;
use Validator;
class UserController extends Controller
{
    public $module_id;
    public function __construct()
    {
        $this->middleware('auth');
        $this->module_id = 5;
    }
    public function index(Request $request)
    {
        if (!Helpers::has_permission($this->module_id . '_view')) {
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
        $data = DB::table('users')->join('roles', 'roles.id', 'users.role_id')->select('users.*', 'roles.name as role_name');
        $datatables = Datatables::of($data);
        $can_update = 0;
        $can_delete = 0;
        if (Helpers::has_permission($this->module_id . '_update')) {
            $can_update = 1;
        }
        if (Helpers::has_permission($this->module_id . '_delete')) {
            $can_delete = 1;
        }
      //  $datatables->addColumn('select', '<label class="m__checkbox"><input type="checkbox" value="{{$id}}" class="checkids" id="checkids_{{$id}}" name="checkids[]"><span></span></label>');
      //  $datatables->rawColumns(['select', 'action']);
        $datatables->addColumn('action', function ($sdata) use ($can_delete, $can_update) {
            $action = '<span class="dropdown">
        <a href="#" class="btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false">
          <i class="la la-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >';
            if ($can_update == 1) {
                $action = $action . '<a  class="dropdown-item ajax-popup" href="' . route("users.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit Details</a>';
                $action = $action . '<a  class="dropdown-item ajax-popup" href="' . route("permissions", ['user', $sdata->id]) . '"><i class="la la-edit"></i> Edit Permissions</a>';
            }
            if ($can_delete == 1) {
                $action = $action . '<a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>';
            }
            $action = $action . '</div></span>';
            return $action;
        });
        return $datatables->make(true);
    }
    public function get_data()
    {
        $data['title'] = "Users";
        $data['data_url'] = route('users.index');
        $fields[] = array('id' => "id", 'name' => "users.id", 'display_name' => "ID");
     //   $fields[] = array('id' => "select", 'name' => "select", 'display_name' => "Select", 'orderable' => "false", 'searchable' => "false");
        $fields[] = array('id' => "user_name", 'name' => "users.user_name", 'display_name' => "User Name");
        $fields[] = array('id' => "email", 'name' => "users.email", 'display_name' => "Email");
        $fields[] = array('id' => "display_name", 'name' => "users.display_name", 'display_name' => "Display Name");
        $fields[] = array('id' => "mobile_no", 'name' => "users.mobile_no", 'display_name' => "Mobile no");
        $fields[] = array('id' => "role_name", 'name' => "roles.name", 'display_name' => "Role Name");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-primary'>Active</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Inactive</span>");
        $fields[] = array('id' => "status", 'name' => "users.status", 'display_name' => "Status", 'condition' => $condition);
        $fields[] = array('id' => "action", 'name' => "action", 'display_name' => "Action", 'orderable' => "false", 'searchable' => "false");
        $data['fields'] = $fields;
        $data['module_id'] = '5';
        $data['create_url'] = route('users.create');
        $data['is_ajax_create'] = 'yes';
        $data['post_type'] = 'get';
        $data['delete_url'] = route('users.destroy', "delete_id");
        $data['is_responsive'] = 'yes';
        
       // $data['approval_column'] = 'yes';
       // $data['approval_conditions'] = array('1' => "Set as Active", '0' => "Set as Inactive", '5' => "Remove Selected");
       // $data['approval_url'] = "";
       // $data['approval_reason'] = 'yes';
        return $data;
    }
    public function create(Request $request)
    {
        if (!Helpers::has_permission($this->module_id . '_add')) {
            return array('status' => false, 'notification' => "No permission!");
        }
        if ($request->ajax()) {
            $view = "ajaxedit";
        } else {
            $view = "edit";
        };
        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create', 'url' => route('users.store'), 'module_id' => '5', 'display_name' => 'User']);
        return view($view)->with(['collection' => $collection, 'rows' => $rows, 'modal_class' => 'modal-lg']);
    }
    public function store(Request $request)
    {
        if (!Helpers::has_permission($this->module_id . '_add')) {
            return array('status' => false, 'notification' => "No permission!");
        }
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users|min:2|max:20',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'display_name' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        $current = Carbon::now();
        $user = new User;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->display_name = $request->display_name;
        $user->mobile_no = $request->mobile_no;
        $user->status = $request->status;
        $user->role_id = $request->role_id;
        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $file = $request->file('image_location');
        if (isset($file)) {
            $user->image_location = $request->file('image_location')->store('avatars');
            Storage::setVisibility($user->image_location, 'public');
            //Storage::disk('s3')->setVisibility($user->image_location, 'public' );
            $user->save();
        }
        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "User Data successfully added.",
            );
        }
        return redirect()->route('users.index')->with('message', 'User data successfully inserted...');
    }
    public function show($id)
    {
        //
    }
    public function edit($id, Request $request)
    {
        if (!Helpers::has_permission($this->module_id . '_update')) {
            return array('status' => false, 'notification' => "No permission!");
        }
        if ($request->ajax()) {
            $view = "ajaxedit";
        } else {
            $view = "edit";
        };
        $user = User::find($id);
        $user->password = "";
        //$rows = collect($this->get_rows());
        $rows = collect($this->get_rows($user, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'url' => 'users', 'module_id' => '5', 'display_name' => 'User Details']);
        return view($view)->with(['model_name' => $user, 'collection' => $collection, 'rows' => $rows, 'modal_class' => 'modal-lg']);
    }
    public function get_rows($model, $form_type)
    {
        $roles = DB::table('roles')->pluck('name', 'id');
        $i = 0;
        $rows[$i][] = array('field_name' => 'user_name', 'label_name' => 'User Name', 'field_type' => 'text', 'placeholder' => 'Enter User Name', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'email', 'label_name' => 'Email', 'field_type' => 'text', 'placeholder' => 'Enter Email Id', 'class_name' => 'email required');
        $rows[$i][] = array('field_name' => 'mobile_no', 'label_name' => 'Mobile no', 'field_type' => 'text', 'placeholder' => 'Enter Mobile no', 'class_name' => 'required');
        $i++;
        $rows[$i][] = array('field_name' => 'display_name', 'label_name' => 'Display Name', 'field_type' => 'text', 'placeholder' => 'Enter First Name', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'role_id', 'label_name' => 'Role', 'field_type' => 'select', 'placeholder' => 'Select Role', 'values_data' => $roles, 'class_name' => 'select2 required', 'id' => 'role_id');
        $status = array("0" => 'Inactive', "1" => "Active");
        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Status', 'values_data' => $status, 'class_name' => 'select2 required', 'id' => 'status');
        $i++;
        $rows[$i][] = array('field_name' => 'password', 'label_name' => 'Password', 'field_type' => 'password', 'placeholder' => 'Enter Password', 'class_name' => '', 'id' => 'password');
        $rows[$i][] = array('field_name' => 'image_location', 'label_name' => 'User Image', 'field_type' => 'image', 'placeholder' => 'Select Image');
        $rows[$i][] = array('field_type' => 'empty');
        return $rows;
    }
    public function update(Request $request, $id)
    {
        if (!Helpers::has_permission($this->module_id . '_update')) {
            return array('status' => false, 'notification' => "No permission!");
        }
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|min:3|max:20',
            'email' => 'email|required',
            'display_name' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        // $current = Carbon::now();
        $user = User::find($id);
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->display_name = $request->display_name;
        $user->mobile_no = $request->mobile_no;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $file = $request->file('image_location');
        if (isset($file)) {
            $user->image_location = $request->file('image_location')->store('avatars');
            Storage::setVisibility($user->image_location, 'public');
            $user->save();
        }
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "User successfully updated...");
        }
        return redirect()->route('users.index')->with('message', 'User successfully updated...');
    }
    public function destroy($id, Request $request)
    {
        if (!Helpers::has_permission($this->module_id . '_delete')) {
            return array('status' => false, 'notification' => "No permission!");
        }
        DB::table('users')->where('id', $id)->delete();
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "User successfully deleted.");
        }
        return redirect()->route('users.index')->with('message', 'User successfully deleted.');
    }
    public function list_users($id, Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return Response::json([]);
        }
        $experts = User::where(function ($q) use ($term) {
            $q->where('user_name', 'like', '%' . $term . '%')
                ->orWhere('display_name', 'like', '%' . $term . '%');
        })->select('users.id', 'users.user_name', 'users.display_name');
        if ($id != 0) {
            $experts = $experts->where('role_id', $id);
        }
        $experts = $experts->limit(20)->get();
        $formatted_experts = [];
        foreach ($experts as $expert) {
            $formatted_experts[] = ['id' => $expert->id, 'text' => $expert->user_name . '-' . $expert->display_name];
        }
        return response()->json($formatted_experts);
    }
}
