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
            Role::create($request->all());
        }
        return Redirect(route('admin.acl'));
    }

    public function deleteRole($role_id)
    {
        Role::destroy($role_id);
        return Redirect(route('admin.acl'));
    }


    public function editPermissionForm($permission_id=null)
    {
        $menu = Menu::get('admin.left_side');
        $menu->item('admin.system.acl')->activate();

        $permission = Permission::where('id', $permission_id)->first();
        if(!$permission) {
            $permission =  new Permission();
        }

        return view('vendor.hobord.admin.permission.permission', ['permission' => $permission]);
    }

    public function editPermission(Request $request)
    {
        if($request->get('id')) { // edit
            $permission = Permission::where('id', $request->get('id'))->first();
            $permission->fill($request->all());
            $permission->save();
        }
        else { //create
            Permission::create($request->all());
        }
        return Redirect(route('admin.acl'));
    }

    public function deletePermission($permission_id)
    {
        Permission::destroy($permission_id);
        return Redirect(route('admin.acl'));
    }



    public function setPermissions(Request $request)
    {

        $roles = Role::all();
        $permissions = Permission::all();
        foreach ($roles as $role) {
            if(array_key_exists($role->name,$request->get('permissions'))) {
                foreach ($permissions as $permission) {
                    $role_permissions = $request->get('permissions')[$role->name];
                    if(in_array($permission->name, $role_permissions)) {
                        if(!$role->hasPermission($permission->name)) {
                            $role->attachPermission($permission);
                        }
                    }
                    else {
                        $role->detachPermission($permission);
                    }
                }
            }
            else { //delete all permission
                foreach ($permissions as $permission) {
                    $role->detachPermission($permission);
                }
            }
        }
        return $this->index();
    }
}