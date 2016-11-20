<?php


namespace Hobord\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Menu;


class UserAdminController  extends Controller
{

    public function index()
    {
        $menu = Menu::get('admin.system');
        $menu->item('admin.system.usermanagement')->active();

        $users = User::paginate(15);

        return view('vendor.hobord.admin.user.list', ['users' => $users]);
    }

    public function createUserForm()
    {
        $menu = Menu::get('admin.system');
        $menu->item('admin.system.usermanagement')->active();

        $user = new User;
        $user->id=null;

        return view('vendor.hobord.admin.user.edit', ['user' => $user]);


    }

    public function editUserForm($user_id)
    {
        $menu = Menu::get('admin.system');
        $menu->item('admin.system.usermanagement')->active();

        $user = User::find($user_id);
        return view('vendor.hobord.admin.user.edit', ['user' => $user]);
    }

    public function editUser(Request $request, $user_id=null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user_id,
            'password' => 'min:6|confirmed',
        ]);

        if ($validator->passes()) {
            if($user_id) {
                $data = ['id' => $user_id];
            }
            else {
                $data = [
                    'id' => $user_id,
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password'))
                ];
            }
            // @var App\User $user;
            $user = User::firstOrCreate($data);

            $user->fill($request->all());
            if($request->get('password')) {
                $user->password = bcrypt($request->get('password'));
            }

            $user->save();
            if($user_id)
                return Redirect::back()->with('messages-success', ['User saved']);
            else
                return Redirect(route('admin.users'));
        }

        $errors = $validator->errors();

        return Redirect::back()->with('messages-danger', $errors->all());
    }
}