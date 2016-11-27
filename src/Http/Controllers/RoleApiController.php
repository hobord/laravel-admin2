<?php


namespace Hobord\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Validator;

class RoleApiController extends Controller
{

    public function listRoles()
    {
        return Role::all();
    }

    public function getRole($role_id = null)
    {
        return Role::whith('permission')->where('id', $role_id)->first();
    }

    public function updateRole(Request $request)
    {
        if($request->get('id')) { // edit
            $role = Role::where('id', $request->get('id'))->first();
            $role->fill($request->all());
            $role->save();
        }
        else { //create
            $role = Role::create($request->all());
        }
        return $role;
    }

    public function deleteRole($role_id)
    {
        Role::destroy($role_id);
    }

    public function attachPermission($role_id, $permission_id)
    {
        $role = Role::where('id', $role_id)->first();
        $permission = Permission::where('id', $permission_id);
        $role->attachPermission($permission);
        $role->save();
        return $role;
    }

    public function detachPermission($role_id, $permission_id)
    {
        $role = Role::where('id', $role_id)->first();
        $permission = Permission::where('id', $permission_id);
        $role->detachPermission($permission);
        $role->save();
        return $role;
    }
}