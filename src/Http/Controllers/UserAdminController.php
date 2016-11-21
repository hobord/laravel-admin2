<?php


namespace Hobord\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Menu;


class UserAdminController  extends Controller
{

    public function index()
    {
        $menu = Menu::get('admin.left_side');
        $menu->item('admin.system.usermanagement')->activate();

        $users = User::with('roles')->paginate(15);

        return view('vendor.hobord.admin.user.list', ['users' => $users]);
    }

    public function createUserForm()
    {
        $menu = Menu::get('admin.left_side');
        $menu->item('admin.system.usermanagement')->activate();

        $user = new User;
        $user->id=null;

        return view('vendor.hobord.admin.user.edit', ['user' => $user]);


    }

    public function editUserForm($user_id)
    {
        $menu = Menu::get('admin.left_side');
        $menu->item('admin.system.usermanagement')->activate();

        $user = User::find($user_id);
        $roles = Role::all();
        return view('vendor.hobord.admin.user.edit', ['user' => $user, 'roles'=>$roles]);
    }

    public function editUser(Request $request, $user_id=null)
    {
        // @var App\User $user;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user_id,
            'password' => 'min:6|confirmed',
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


                $user->detachRoles($user->roles);
                $roles = Role::whereIn('name', $data['roles'])->get();
                $user->attachRoles($roles);

                $user->save();
                return Redirect::back()->with('messages-success', ['User saved']);
            } else {
                $data = [
                    'id' => $user_id,
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password'))
                ];
                User::create($data);
                return Redirect(route('admin.users'));
            }
        }

        $errors = $validator->errors();
        return Redirect::back()->with('messages-danger', $errors->all());
    }

    public function deleteUser($user_id)
    {
        User::destroy($user_id);
        return Redirect(route('admin.users'))->with('messages-success', ['User deleted!']);
    }
}