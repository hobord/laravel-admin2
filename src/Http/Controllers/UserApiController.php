<?php
namespace Hobord\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Response;

class UserApiController extends Controller
{
    public function listUsers(Request $request)
    {
        $order_by = ($request->get('order_by')) ? $request->get('order_by') : 'id';
        $order = ($request->get('order')) ? $request->get('order') : 'desc';
        $paginate_size = (int) ($request->get('psize')) ? $request->get('psize') : 15;

        if($request->get('with_roles') == true) {
            return User::orderBy($order_by, $order)->with('roles')->paginate($paginate_size);
        }
        else {
            return User::orderBy($order_by, $order)->paginate($paginate_size);
        }
    }

    public function getUser($id)
    {
        return User::with('roles')->find($id);
    }

    public function updateUser(Request $request)
    {
        // @var App\User $user;
        $user_id = $request->get('id');

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user_id,
            'password' => 'min:6',
        ]);

        if ($validator->passes()) {
            if ($user_id) {
                $data = $request->all();
                $password = $request->get('password');
                unset($data['password']);

                $user = User::find($user_id);
                $user->fill($data);
                if ($password && $password != '') {
                    $user->password = bcrypt($password);
                }

                $user->save();
            } else {
                $data = [
                    'id' => $user_id,
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password'))
                ];
                $user = User::create($data);
            }

            return $user;
        }

        $returnData = array(
            'status' => 'error',
            'errors' => $validator->errors()->all()
        );
        return Response::json($returnData, 500);
    }

    public function deleteUser($user_id)
    {
        User::destroy($user_id);
        return Response::json(['success'=>true]);;
    }

    public function getRoles($user_id)
    {
        $user = User::find($user_id);

        return $user->roles;
    }
    public function attachRoles(Request $request)
    {
        $user = User::find($request->get('user_id'));

        $attach_roles = $request->get('roles');
        $roles = Role::whereIn('name', $attach_roles)->get();
        $user->attachRoles($roles);
        $user->save();

        return $user;
    }
    public function detachRoles(Request $request)
    {
        $user = User::find($request->get('user_id'));

        $detach_roles = $request->get('roles');
        $roles = Role::whereIn('name', $detach_roles)->get();
        $user->detachRoles($roles);
        $user->save();

        return $user;
    }
}