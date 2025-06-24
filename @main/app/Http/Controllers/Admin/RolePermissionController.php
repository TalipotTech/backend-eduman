<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\AuthorCategoryEnum;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:permission-list', ['only' => ['index','show']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view("dashboard.role_permission.list", compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nodeTypes = array();
        $permissions = array();
        $users = User::all();
        $roles = Role::all();
        $permissionsQueryData = Permission::all()->pluck('name', 'id')->toArray();
        
        foreach($permissionsQueryData as $key => $permission)
        {
            $typeArray = explode('-', $permission);
            $type = !empty($typeArray) ? $typeArray[0] : "";

            if( !in_array($type, $nodeTypes) )
            {
                $nodeTypes[$type] = str_replace("_"," ", $type);
            }

            if( !in_array($permission, $permissions) )
            {
                $permissions[$nodeTypes[$type]][] = $key;
            }
        }

        $rolePermissions = "";
        $email = !empty($_GET['email']) ? $_GET['email'] : '';
        $role = !empty($_GET['role']) ? $_GET['role'] : '';
        if( !empty($email) )
        {
            $checkUser = User::where('email', $email)->first();
            $roleId = $checkUser->roles->pluck('id')->first();
            // check existing permissions
            $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                ->where("role_has_permissions.role_id", $roleId)
                ->get()
                ->pluck('id', 'id')
                ->toArray();
        }

        return view("dashboard.role_permission.edit", 
            compact("roles", "users", "permissions", "rolePermissions", "email", "role")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if ( !empty($request->name) )
        {
            $role = Role::create(['name' => $request->name]);

            if ($role) {
                return redirect()->route("dashboard.role_permission.new")
                    ->with(ResponseMessage::createSucceed(__("Role")));
            }
        }
        else {

            if ( !empty($request->check_email) && !empty($request->check_role) )
            {
                
                return redirect()->route("dashboard.role_permission.new", [
                    'email' => $request->check_email,
                    'role' => $request->check_role
                ]);
            }

            $request->validate([
                'email' => 'required|string',
                'role' => 'required|string',
                'user_permission' => 'nullable|array',
            ]);

            $user = User::where('email', $request->email)->first();
            $role = Role::where('name', $request->role)->first();
            // user permission
            $role->syncPermissions($request->user_permission);
            $user->assignRole([$role->id]);

            $email = !empty($_GET['email']) ? $_GET['email'] : '';
            $role = !empty($_GET['role']) ? $_GET['role'] : '';

            if ($role) {
                return redirect()->route("dashboard.role_permission.new", [
                    'email' => $email,
                    'role' => $role
                ])
                    ->with(ResponseMessage::createSucceed(__("Role")));
            }
        }
        
        return back()->withErrors(ResponseMessage::createFailed(__("Role")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $deleted = $role->delete();

        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Role")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Role")));
    }
}
