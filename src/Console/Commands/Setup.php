<?php

namespace Hobord\Admin\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Role;
use App\Permission;
use Hobord\MenuDb\Menu;
use Hobord\MenuDb\MenuItem;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin package setup';

    protected $validation = [
        'email' => 'required|email',
        // e.g. 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed'
        'password' => 'required|min:4|confirmed'
    ];

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer  $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createPermissionRoles();
        $this->createAdminMenu();
        $this->createRootUser();

    }

    public function createPermissionRoles()
    {
        $rootRole = Role::where('name','admin.root')->first();
        if($rootRole) {
            return;
        }

        $rootRole = new Role();
        $rootRole->name      = 'admin.root';
        $rootRole->display_name = 'Super User';
        $rootRole->description  = 'This is the root super user.';
        $rootRole->save();

        $new_perm = new Permission();
        $new_perm->name         = 'admin.access';
        $new_perm->display_name = 'Access admin';
        $new_perm->description  = 'Access administration pages.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);


        $new_perm = new Permission();
        $new_perm->name         = 'admin.users.manage';
        $new_perm->display_name = 'Manage users';
        $new_perm->description  = 'Access user managements.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);


        $new_perm = new Permission();
        $new_perm->name         = 'admin.users.create';
        $new_perm->display_name = 'Create users';
        $new_perm->description  = 'Create users.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);


        $new_perm = new Permission();
        $new_perm->name         = 'admin.users.edit';
        $new_perm->display_name = 'Edit users';
        $new_perm->description  = 'Edit users.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);

        $new_perm = new Permission();
        $new_perm->name         = 'admin.users.edit.password';
        $new_perm->display_name = 'Edit users';
        $new_perm->description  = 'Edit users.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);

        $new_perm = new Permission();
        $new_perm->name         = 'admin.users.edit.roles';
        $new_perm->display_name = 'Edit users';
        $new_perm->description  = 'Edit users.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);

        $new_perm = new Permission();
        $new_perm->name         = 'admin.users.delete';
        $new_perm->display_name = 'Delete users';
        $new_perm->description  = 'Delete users.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);


        $new_perm = new Permission();
        $new_perm->name         = 'admin.acl.manage';
        $new_perm->display_name = 'Manage permissions';
        $new_perm->description  = 'Manage permissions and roles.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);

        $new_perm = new Permission();
        $new_perm->name         = 'admin.menu.manage';
        $new_perm->display_name = 'Manage menus';
        $new_perm->description  = 'Manage menus.';
        $new_perm->save();

        $rootRole->attachPermission($new_perm);
    }

    public function createAdminMenu()
    {
        $admin_menu = Menu::where('machine_name', 'admin.left_side')->first();
        if($admin_menu) {
            return;
        }

        $admin_menu = Menu::create([
            'machine_name' => 'admin.left_side',
            'display_name' => 'System',
            'description' => 'Main left side system menu'
        ]);

        $system_menu = MenuItem::create([
            'menu_id' => $admin_menu->id,
            'parent_id' => null,
            'unique_name' => 'admin.system',
            'menu_text' => '<i class="fa fa-laptop"></i><span>System</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>',
            'parameters' => [
                 'class'=>"treeview"
            ]
        ]);


        MenuItem::create([
            'menu_id' => $admin_menu->id,
            'parent_id' => $system_menu->id,
            'unique_name' => 'admin.system.usermanagement',
            'menu_text' => '<i class="fa fa-users"></i>Users',
            'parameters' => [
                'route'  => 'admin.users',
                'permission' => 'admin.users.manage',
                'class'=>"treeview"
            ]
        ]);

        MenuItem::create([
            'menu_id' => $admin_menu->id,
            'parent_id' => $system_menu->id,
            'unique_name' => 'admin.system.acl',
            'menu_text' => '<i class="fa fa-check-square-o"></i>Permissions',
            'parameters' => [
                'route'  => 'admin.acl',
                'permission' => 'admin.acl.manage',
                'class'=>"treeview"
            ]
        ]);


        $structure_menu = MenuItem::create([
            'menu_id' => $admin_menu->id,
            'parent_id' => null,
            'unique_name' => 'admin.system',
            'menu_text' => '<i class="fa fa-sitemap"></i><span>Sturcture</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>',
            'parameters' => [
                'class'=>"treeview"
            ]
        ]);

        MenuItem::create([
            'menu_id' => $admin_menu->id,
            'parent_id' => $structure_menu->id,
            'unique_name' => 'admin.structure.menu',
            'menu_text' => '<i class="fa fa-sitemap"></i>Menus',
            'parameters' => [
                'route'  => 'admin.menu',
                'permission' => 'admin.menu.manage',
                'class'=>"treeview"
            ]
        ]);

    }

    public function createRootUser()
    {
        $email = $this->emailPrompt();

        $user = User::where('email', $email)->first();

        if(!$user) {
            $this->info("The user is not exists so we create them.");
            $name = $this->ask("Please enter admin user's full name");
            $password = $this->passwordPrompt();

            $user_id = $this->createUser($email,$password,$name);
            $user = User::where('id', $user_id)->first();
        }

        $this->addRootPermissions($user);
    }

    public function emailPrompt($email = null) {
        $email = $this->ask("Please enter email address for admin user");

        $validator = Validator::make(['email' => $email],['email' => $this->validation['email']]);
        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'),'error');
            return $this->emailPrompt();
        }
        return $email;
    }

    protected function passwordPrompt() {
        $input = [
            'password' => $this->secret("Please enter password for new user"),
            'password_confirmation' => $this->secret("Please re-enter password")
        ];
        $validator = Validator::make($input, ['password' => $this->validation['password']]);
        if ($validator->fails()) {
            $this->error($validator->errors()->first('password'),'error');
            return $this->passwordPrompt();
        }
        return $input['password'];
    }

    /**
     * Create a user record
     *
     * @param $email
     * @param $password
     * @param $name
     *
     * @return int
     */
    protected function createUser($email, $password, $name) {
        $now = new Carbon;
        $id = DB::table('users')->insertGetId([
            'email' => $email,
            'password' => bcrypt($password),
            'name' => $name,
            'created_at'=> $now,
            'updated_at' => $now,
        ]);
        return $id;
    }

    public function addRootPermissions($user)
    {
        $rootRole = Role::where('name','admin.root')->first();

        $user->attachRole($rootRole);

    }
}