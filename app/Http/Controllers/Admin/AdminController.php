<?php

namespace App\Http\Controllers\Admin;

use App\Enum\AdminStatusEnum;
use App\Enum\AdminTypeEnum;
use App\Helper\ControllerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if(!ControllerHelper::checkAuthorization(config('access.users.admin-read'),auth()->user()->roles)) return view('welcome');

        $status = true;

        if (!empty($request->status) && $request->status == AdminStatusEnum::INACTIVE->value) $status = false;

        view()->share('page', config('app.nav.admins'));

        if (auth()->user()->admin_type == AdminTypeEnum::REGULAR->value){
            $admins = Admin::where('line_manager_id', auth()->user()->id)->where('status', $status)->orderBy('id', 'ASC')->get();
            $admins->push(Admin::find(auth()->user()->id));
        }
        else $admins = Admin::where('status', $status)->orderBy('id', 'ASC')->get();

        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        if(!ControllerHelper::checkAuthorization(config('access.users.admin-write'), auth()->user()->roles)) return view('welcome');

        view()->share('page', config('app.nav.admins'));

        return view('admin.create');
    }

    public function store(AdminCreateRequest $request)
    {
        if (!ControllerHelper::checkAuthorization(config('access.users.admin-write'), auth()->user()->roles)) return view('welcome');

        $roles = array_map('intval', $request->roles ?? []);

        $phone = "+880" . substr($request->phone, -10);

        $admin = new Admin();
        $admin->name            = $request->name;
        $admin->designation     = $request->designation;
        $admin->phone           = $phone;
        $admin->email           = $request->email;
        $admin->admin_type      = $request->admin_type;
        $admin->password        = Hash::make($request->password);
        $admin->roles           = json_encode($roles);


        if ($request->admin_type == "REGULAR") $admin->line_manager_id = auth()->user()->id;
        else $admin->line_manager_id = NULL;

        if (!empty($request->avatar)) $admin->avatar = $request->file('avatar')->store('admin_avatar', 'public');;

        $admin->save();

        try {
            $description = [
                'action_type'   => 'add_new_admin',
                'admin'         => $admin,
            ];

            $action_by = [
                'user_type' => 'admin',
                'user_id'   => auth()->user()->id,
                'user_name' => auth()->user()->name,
            ];

            (new LogEventController())->saveLogEvent(null, null, $description, $action_by);

        } catch (\Exception $e) { }

        return redirect()->back()->with('success', 'New admin added successfully');
    }


    public function edit(Admin $admin)
    {
        if(!ControllerHelper::checkAuthorization(config('access.users.admin-write'), auth()->user()->roles)) return view('welcome');

        view()->share('page', config('app.nav.admins'));

        $all_admins = Admin::select('id','name')->where('status',1)->orderBy('name','asc')->get();


        return view('admin.edit',compact('admin', 'all_admins'));
    }

    public function update(Request $request,Admin $admin)
    {
        if(!ControllerHelper::checkAuthorization(config('access.users.admin-write'), auth()->user()->roles)) return view('welcome');

        $request->validate([
            'name'              => 'required|string',
            'phone'             => 'required|unique:admins,phone,'.$admin->id,
            'email'             => 'required|string|email|max:255|unique:admins,email,'.$admin->id,
            'password'          => 'nullable|string|min:6|confirmed',
            'admin_type'        => ['required', Rule::in(array_column(AdminTypeEnum::cases(),'value'))],
            'status'            => ['required', Rule::in(array_column(AdminStatusEnum::cases(),'value'))],
            'avatar'            => ['nullable', 'mimes:jpeg,jpg,png,gif|required|max:10000']
        ]);

        $roles = [];
        if (!empty($request->roles)) $roles = array_map('intval', $request->roles);

        //log event
        $previous_data = array();
        $updated_data = array();
        $description = array();

        if ($admin->name != $request->name) {
            $previous_data['name'] = $admin->name;
            $updated_data['name']  = $request->name;
        }

        if ($admin->designation != $request->designation) {
            $previous_data['designation'] = $admin->designation;
            $updated_data['designation'] = $request->designation;
        }

        $phone = "+880".substr($request->phone,-10);
        if ($admin->phone != $phone) {
            $phone_check = Admin::query()->where('phone', $phone)->first();
            if (!empty($phone_check)) return redirect()->back()->with('error', 'This Phone Number is already exist');

            $previous_data['phone'] = $admin->phone;
            $updated_data['phone']  = $phone;
        }

        if ($admin->email != $request->email) {
            $email_check = Admin::query()->where('email', $request->email)->first();
            if (!empty($email_check)) return redirect()->back()->with('error', 'This Email is already exist');

            $previous_data['email'] = $admin->email;
            $updated_data['email'] = $request->email;
        }

        if ($admin->roles != json_encode($roles)) {
            $previous_data['roles'] = $admin->roles;
            $updated_data['roles']  = json_encode($roles);
        }

        if ($admin->status != $request->status) {
            $previous_data['status'] = $admin->status;
            $updated_data['status'] = $request->status;
        }

        if ($admin->admin_type != $request->admin_type) {
            $previous_data['admin_type']    = $admin->admin_type;
            $updated_data['admin_type']     = $request->admin_type;
        }

        $description['action_type'] = 'admin_update';
        $description['mobile']      = $admin->phone;
        $description['admin_id']    = $admin->id;
        $action_by =[
            'user_type' => 'admin',
            'user_id'   => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ];

        $admin->name        = $request->name;
        $admin->designation = $request->designation;
        $admin->phone       = $phone;
        $admin->email       = $request->email;
        $admin->roles       = json_encode($roles);
        $admin->status      = $request->status == "ACTIVE" ? 1 : 0;
        $admin->admin_type  = $request->admin_type;

        if ($request->admin_type == "REGULAR") $admin->line_manager_id = $request->line_manager_id;
        else $admin->line_manager_id = NULL;

        if(!empty($request->password)){
            $admin->password = Hash::make($request->password);
            $description['password'] = 'password_change';
        }

        if(!empty($request->avatar)){
            if ($admin->avatar) {
                Storage::delete($admin->avatar);
            }

            $admin->avatar = $request->file('avatar')->store('admin_avatar', 'public');
        }

        $admin->save();

        (new LogEventController())->saveLogEvent($previous_data, $updated_data, $description, $action_by);
        return Redirect()->back()->with('success', 'Admin updated successfully');
    }

    public function profile()
    {
        view()->share('page', config('app.nav.admins'));

        $user = Auth::user();

        return view('admin.profile', compact('user'));
    }
}
