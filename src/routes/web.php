<?php

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => '/', 'middleware' => ['auth','permission:admin.access']], function () {

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
        ])->name('admin.users.create');
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
        Route::get('/permissions',  [
            'middleware' => ['permission:admin.acl.manage'],
            'uses' =>'PermissionsController@index'
        ])->name('admin.acl');

    });

    Route::get('/logout', function () {
        Auth::logout();
        return redirect(route('admin.index'));
    })->name('admin.logout');

});

