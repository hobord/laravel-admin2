<?php


namespace Hobord\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionApiController extends Controller
{

    public function listPermissions()
    {
        return Permission::all();
    }

    public function getPermission($permission_id = null)
    {
        return Permission::whith('permission')->where('id', $permission_id)->first();
    }

    public function updatePermission(Request $request)
    {
        if($request->get('id')) { // edit
            $permission = Permission::where('id', $request->get('id'))->first();
            $permission->fill($request->all());
            $permission->save();
        }
        else { //create
            $permission = Permission::create($request->all());
        }
        return $permission;
    }

    public function deletePermission($permission_id)
    {
        Permission::destroy($permission_id);
    }
}