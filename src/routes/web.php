<?php

Route::group(['prefix' => 'admin'], function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect(route('admin.index'));
    })->name('admin.logout');

    Route::group(['prefix' => '/api/user',
        'middleware' => ['permission:admin.users.manage']
        ], function () {
        Route::get('/',                   'UserApiController@listUsers');
        Route::get('/{id}',               'UserApiController@getUser');
        Route::post('/',                  'UserApiController@updateUser');
        Route::get('/{id}/delete',        'UserApiController@deleteUser');
        Route::get('/{id}/roles',         'UserApiController@getRoles');
        Route::post('/{id}/roles/attach', 'UserApiController@attachRoles');
        Route::post('/{id}/roles/detach', 'UserApiController@detachRoles');
    });

    Route::group(['prefix' => '/api/acl'], function () {

        Route::group(['prefix' => '/role'], function () {
            Route::get('/', 'RoleApiController@listRoles');
            Route::get('/{id}', 'RoleApiController@getRole');
            Route::post('/', [
                'middleware' => ['permission:admin.acl.manage'],
                'uses' => 'RoleApiController@updateRole'
            ]);
            Route::get('/{role_id}/attach_permission/{permission_id}', [
                'middleware' => ['permission:admin.acl.manage'],
                'uses' => 'RoleApiController@attachPermission'
            ]);
            Route::get('/{role_id}/detach_permission/{permission_id}', [
                'middleware' => ['permission:admin.acl.manage'],
                'uses' => 'RoleApiController@detachPermission'
            ]);
            Route::get('/{id}/delete', [
                'middleware' => ['permission:admin.acl.manage'],
                'uses' => 'RoleApiController@deleteRole'
            ]);
        });
        Route::group(['prefix' => '/permission'], function () {
            Route::get('/', 'PermissionApiController@listPermissions');
            Route::get('/{id}', 'PermissionApiController@get');
            Route::post('/', [
                'middleware' => ['permission:admin.acl.manage'],
                'uses' => 'PermissionApiController@update'
            ]);
            Route::get('/{id}/delete', [
                'middleware' => ['permission:admin.acl.manage'],
                'uses' => 'PermissionApiController@delete'
            ]);
        });


    });


    Route::group(['prefix' => '/',
        'middleware' => ['auth','permission:admin.access']
        ], function () {

        Route::get('/', function () {


            return view('vendor.hobord.admin.index');
        })->name('admin.index');

        // USER
        Route::get('/users', [
            'middleware' => ['permission:admin.users.manage'],
            'uses' =>'UserAdminController@index'
        ])->name('admin.users');

        Route::get('/user/create', [
            'middleware' => ['permission:admin.users.create'],
            'uses' =>'UserAdminController@createUserForm'
        ])->name('admin.user.create');
        Route::get('/user/{id}/delete', [
            'middleware' => ['permission:admin.users.delete'],
            'uses' =>'UserAdminController@deleteUser'
        ])->name('admin.users.delete');
        Route::get('/user/{id}', [
            'middleware' => ['permission:admin.users.edit'],
            'uses' =>'UserAdminController@editUserForm'
        ])->name('admin.users.edit');
        Route::post('/user/{id?}', [
            'middleware' => ['permission:admin.users.edit'],
            'uses' =>'UserAdminController@editUser'
        ])->name('admin.users.edit');



        // ACL
        Route::post('/permissions',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@setPermissions'
        ])->name('admin.acl');

        Route::get('/permissions',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@index'
        ])->name('admin.acl');

        Route::post('/permissions/role/save',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@editRole'
        ])->name('admin.acl.edit.role.save');
        Route::get('/permissions/role/delete/{id}',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@deleteRole'
        ])->name('admin.acl.delete.role');
        Route::get('/permissions/role/{id?}',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@editRoleForm'
        ])->name('admin.acl.edit.role');

        Route::post('/permissions/permission/save',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@editPermission'
        ])->name('admin.acl.edit.permission.save');
        Route::get('/permissions/permission/delete/{id}',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@deletePermission'
        ])->name('admin.acl.delete.permission');
        Route::get('/permissions/permission/{id?}',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsAdminController@editPermissionForm'
        ])->name('admin.acl.edit.permission');



    });





});

