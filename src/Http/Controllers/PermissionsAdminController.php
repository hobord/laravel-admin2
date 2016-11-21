<?php


namespace Hobord\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Menu;


class PermissionsAdminController  extends Controller
{

    public function index()
    {
        $menu = Menu::get('admin.left_side');
        $menu->item('admin.system.acl')->activate();

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('vendor.hobord.admin.permission.list', ['roles' => $roles, 'permissions' =>$permissions]);
    }

    public function editRoleForm($role_id=null)
    {
//        dd('hello');
        $menu = Menu::get('admin.left_side');
        $menu->item('admin.system.acl')->activate();

        $role = Role::with('permissions')->where('id', $role_id)->first();
        if(!$role) {
            $role =  new Role();
        }

        return view('vendor.hobord.admin.permission.role', ['role' => $role]);
    }

    public function editRole(Request $request)
    {
        if($request->get('id')) { // edit
            $role = Role::where('id', $request->get('id'))->first();
            $role->fill($request->all());
            $role->save();
        }
        else { //create
            $role = Role::create([
                'name' => $request->get('name'),
                'display_name' => $request->get('display_name'),
                'description' => $request->get('description'),
            ]);
        }
        return Redirect(route('admin.acl'));
    }
}